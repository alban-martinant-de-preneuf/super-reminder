console.log('todo.js charged !')

const listContainer = document.getElementById('list_container')
const addListBtn = document.getElementById('add_list_btn')

async function getLists() {
    console.log('getLists()')
    const res = await fetch('/super-reminder/lists')
    const data = await res.json()

    return data
}

async function displayLists(lists) {
    let existingLists = []
    lists.forEach(element => {
        if (!existingLists.includes(element.id_list)) {
            console.log(element.id_list)
            existingLists.push(element.id_list)
            const list = document.createElement('div')
            list.classList.add('list')
            list.id = "list_" + element.id_list
            const listTitle = document.createElement('h2')
            listTitle.textContent = element.title_list
            list.appendChild(listTitle)
            const ulElement = document.createElement('ul')
            ulElement.id = "ul_" + element.id_list
            list.appendChild(ulElement)
            listContainer.appendChild(list)
        } else {
            existingLists.push(element.id_list)
        }
        const currentUl = document.getElementById("ul_" + element.id_list)
        const liElement = document.createElement('li')
        liElement.textContent = element.title_task
        currentUl.appendChild(liElement)
    })
}

async function addList(e) {
    // to do
}
    

addListBtn.addEventListener('click', addList)

getLists().then(lists => {
    console.log(lists)
    displayLists(lists)
})