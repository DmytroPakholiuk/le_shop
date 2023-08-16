
let definitionForm = document.getElementById('definition-form')
// let addButton = document.createElement('button')
// addButton.classList.add('btn', 'btn-primary')
// addButton.innerText = 'add dictionary definition'
// addButton.addEventListener('click', function (ev) {
//     generateDefinitionHtml()
// })
// definitionForm.append(addButton)


let loaded = false
let definitionCount = 0

let dropdownList = document.getElementById('type-select')
let selectedDictionary = document.getElementById('type-select').options[dropdownList.selectedIndex].text === 'dictionary'
selectType()

function selectType()
{
    let categorySelect = document.getElementById('category-select')
    let selectedText = dropdownList.options[dropdownList.selectedIndex].text

    if (selectedText === 'dictionary'){
        selectedDictionary = true
        definitionForm.hidden = false
        if (document.title.includes('create')){

        } else if (document.title.includes('update')){

        }
    } else {
        definitionForm.hidden = true
    }
}

function generateDefinitionHtml(name = '')
{
    if (definitionCount < 100){

        let definitionDiv = document.createElement('div')
        definitionDiv.classList.add('row')
        definitionDiv.id = 'definition-' + definitionCount

        let valueInput = document.createElement('input')
        valueInput.classList.add('form-control', 'col-6')
        valueInput.style.margin = '10px'
        valueInput.value = name
        valueInput.name = 'Attribute[dictionaryDefinition]['+definitionCount+']'


        let deleteButton = document.createElement('button')
        deleteButton.classList.add('btn', 'btn-danger', 'col-1')
        deleteButton.textContent = 'delete definition'
        deleteButton.style.margin = '10px'
        deleteButton.addEventListener('click', function (ev) {
            ev.currentTarget.parentElement.innerHTML = ''
        })

        definitionDiv.append(valueInput, deleteButton)
        definitionForm.append(definitionDiv)

        definitionCount++
    } else {
        alert('Too many attributes')
    }
}

// function eraseElement(ev){
//     ev.currentTarget.parentElement.innerHTML = ''
// }

function eraseElement(id){
    let deletingDiv = document.getElementById(id)
    deletingDiv.innerHTML = ''
}
