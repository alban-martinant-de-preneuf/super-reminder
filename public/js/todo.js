console.log('todo.js charged !')

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

function displayLists(lists) {
    console.log('displayLists()')
    lists.forEach(async (list) => {
        const tasks = await getTasks(list.id)
        const listDiv = document.createElement('div')
        listDiv.classList.add('list')
        listDiv.id = "list_" + list.id
        const listTitle = document.createElement('h2')
        listTitle.textContent = list.title
        listDiv.appendChild(listTitle)
        const ulElement = document.createElement('ul')
        ulElement.id = "ul_" + list.id
        listDiv.appendChild(ulElement)
        listContainer.appendChild(listDiv)
        tasks.forEach(task => {
            const liElement = document.createElement('li')
            liElement.textContent = task.title
            ulElement.appendChild(liElement)
        })
    })
}

async function addList(e) {
    e.preventDefault()
    console.log('addList()')
    const formdata = new FormData(formAddList)
    const res = await fetch('/super-reminder/lists/add', {
        method: 'POST',
        body: formdata
    })
}


formAddList.addEventListener('submit', addList)

getLists().then(lists => {
    console.log(lists)
    displayLists(lists)
})