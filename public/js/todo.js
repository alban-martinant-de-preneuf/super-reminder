
const listContainer = document.getElementById('list_container')
const addListBtn = document.getElementById('add_list_btn')
const formAddList = document.getElementById('add_list_form')

async function getLists() {
    console.log('getLists()')
    const res = await fetch('/super-reminder/lists')
    const data = await res.json()

    return data
}

async function getTasks(listId) {
    console.log('getTasks()')
    const res = await fetch('/super-reminder/tasks/' + listId)
    const data = await res.json()

    return data
}

// function displayLists(lists) {

//     lists.forEach(list => displayList(list))
// }

// //         const tasks = await getTasks(list.id)

// //         fillWithLiTasks(tasks, ulElement)
// //     })
// // }

async function displayList(list) {
    console.log(list)
    const listDiv = document.createElement('div')
    listDiv.classList.add('list')
    listDiv.id = "list_" + list.id

    const listTitle = document.createElement('h2')
    listTitle.textContent = list.title
    listDiv.appendChild(listTitle)

    listDiv.appendChild(addTaskForm(list.id))

    const ulElement = document.createElement('ul')
    ulElement.id = "ul_" + list.id
    listDiv.appendChild(ulElement)

    listContainer.prepend(listDiv)

    const tasks = await getTasks(list.id)

    fillWithLiTasks(tasks, ulElement)
}

function fillWithLiTasks(tasks, ulElement) {
    tasks.forEach(task => {
        console.log(task)
        const liElement = document.createElement('li')
        liElement.textContent = task.title
        ulElement.appendChild(liElement)
    })
}

function addTaskForm(listId) {
    console.log('addTaskForm()')
    const form = document.createElement('form')
    form.id = "add_task_form_" + listId
    form.classList.add('add_task_form')

    const inputTitle = document.createElement('input')
    inputTitle.type = "text"
    inputTitle.name = "title"
    inputTitle.id = "title"
    inputTitle.placeholder = "Title"
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
    submitBtn.innerHTML = '<i class="fa-solid fa-circle-plus"></i>'
    form.appendChild(submitBtn)

    form.addEventListener('submit', async (e) => {
        e.preventDefault()
        const formData = new FormData(form)
        const res = await fetch('/super-reminder/tasks/add', {
            method: 'POST',
            body: formData,
        })
        const data = await res.json()
        console.log(data)
        if (data.message === 'Task added') {
            const ulElement = document.getElementById('ul_' + listId)
            const liElement = document.createElement('li')
            liElement.textContent = data.title
            ulElement.appendChild(liElement)
        }
    })

    return form
}

async function addList(e) {
    e.preventDefault()
    console.log('addList()')
    const formdata = new FormData(formAddList)
    const res = await fetch('/super-reminder/lists/add', {
        method: 'POST',
        body: formdata
    })
    const data = await res.json()
    console.log(data)
    if (data.message === 'List added') {
        displayList(data.list)
    }
}

getLists().then(lists => {
    lists.forEach(list => displayList(list))
})

formAddList.addEventListener('submit', (e) => addList(e))