
const listContainer = document.getElementById('list_container')
const addListBtn = document.getElementById('add_list_btn')
const formAddList = document.getElementById('add_list_form')

async function getLists() {
    const res = await fetch('/super-reminder/lists')
    const data = await res.json()

    return data
}

async function getTasks(listId) {
    const res = await fetch('/super-reminder/tasks/' + listId)
    const data = await res.json()

    return data
}

async function displayList(list) {
    const listDiv = document.createElement('div')
    listDiv.classList.add('list')
    listDiv.id = "list_" + list.id

    const deleteIcon = document.createElement('i')
    deleteIcon.classList.add('fa-solid', 'fa-xmark')
    deleteIcon.addEventListener('click', () => {
        deleteList(list.id, listDiv)
    })

    listDiv.appendChild(deleteIcon)

    const listTitle = document.createElement('h2')
    listTitle.textContent = list.title
    listDiv.appendChild(listTitle)

    listDiv.appendChild(addTaskForm(list.id))

    const ulElement = document.createElement('ul')
    ulElement.id = "ul_" + list.id
    ulElement.classList.add('list_tasks')
    listDiv.appendChild(ulElement)

    listContainer.prepend(listDiv)

    const tasks = await getTasks(list.id)

    fillWithLiTasks(tasks, ulElement)
}

async function deleteList(listId, listDiv) {
    const res = await fetch('/super-reminder/lists/delete/' + listId, {
        method: 'DELETE'
    })
    const data = await res.json()
    if (data.message === 'List deleted') {
        listDiv.remove()
    }
}

function fillWithLiTasks(tasks, ulElement) {
    tasks.forEach(task => {
        ulElement.appendChild(createLiTask(task))
    })
}

function createLiTask(task) {
    const liElement = document.createElement('li')
    liElement.id = "task_" + task.id
    liElement.classList.add('task')
    if (task.state === 'completed') {
        liElement.classList.add('completed')
    }

    const checkIcon = document.createElement('i')
    checkIcon.classList.add('fa-solid', 'fa-check')
    liElement.appendChild(checkIcon)

    const spanElement = document.createElement('span')
    spanElement.textContent = task.title
    liElement.appendChild(spanElement)

    const trashIcon = document.createElement('i')
    trashIcon.classList.add('fa-regular', 'fa-trash-can')
    liElement.appendChild(trashIcon)

    addTaskEventListeners(liElement, task)

    return liElement
}

function addTaskEventListeners(liElement, task) {
    // check task
    liElement.querySelector('.fa-check').addEventListener('click', async () => {
        const res = await fetch('/super-reminder/tasks/changestate', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(task)
        })
        const data = await res.json()
        if (data.state === 'completed') {
            liElement.classList.add('completed')
            task.state = 'completed'
        } else if (data.state === 'pending') {
            liElement.classList.remove('completed')
            task.state = 'pending'
        }
    })
    // delete task
    liElement.querySelector('.fa-trash-can').addEventListener('click', async () => {
        const res = await fetch('/super-reminder/tasks/delete/' + task.id, {
            method: 'DELETE'
        })
        const data = await res.json()
        if (data.message === 'Task deleted') {
            liElement.remove()
        }
    })
}

function addTaskForm(listId) {
    const form = document.createElement('form')
    form.id = "add_task_form_" + listId
    form.classList.add('add_task_form')

    const inputTitle = document.createElement('input')
    inputTitle.type = "text"
    inputTitle.name = "title"
    inputTitle.id = "title"
    inputTitle.placeholder = "New task"
    form.appendChild(inputTitle)

    const inputListId = document.createElement('input')
    inputListId.hidden = true
    inputListId.type = "text"
    inputListId.name = "list_id"
    inputListId.id = "list_" + listId
    inputListId.value = listId
    form.appendChild(inputListId)

    const submitBtn = document.createElement('button')
    submitBtn.type = "submit"
    submitBtn.innerHTML = '<i class="fa-solid fa-circle-plus add_task_icon"></i>'
    form.appendChild(submitBtn)

    form.addEventListener('submit', async (e) => {
        e.preventDefault()
        const formData = new FormData(form)
        const res = await fetch('/super-reminder/tasks/add', {
            method: 'POST',
            body: formData,
        })
        const data = await res.json()
        if (data.message === 'Task added') {
            const ulElement = document.getElementById('ul_' + listId)
            ulElement.appendChild(createLiTask(data.task))
        }
    })

    return form
}

async function addList(e) {
    e.preventDefault()
    const formdata = new FormData(formAddList)
    const res = await fetch('/super-reminder/lists/add', {
        method: 'POST',
        body: formdata
    })
    const data = await res.json()
    if (data.message === 'List added') {
        displayList(data.list)
    }
}

getLists().then(lists => {
    lists.forEach(list => displayList(list))
})

formAddList.addEventListener('submit', (e) => addList(e))