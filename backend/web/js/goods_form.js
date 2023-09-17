/**
 * @var goodsId
 */
/**
 *
 * @type {number}
 */
let i = 0;
let attributeForm = document.getElementById('attributeForm');
let categoryPicker = jQuery('#categoryPicker');
// let submitButton = $('#submitButton');
let submitButton = document.getElementById('submitButton');
let attributeValidators = [];
let validatorCount = 0;


if (categoryPicker.val() !== '') {
    renderAttributeForm()
}





function addAttribute(){

    /*
    let attributesDiv = document.getElementById('attributeForm');
    let rows = attributesDiv.children;

    for (let row of rows) {
       for (let col of row.children) {
           let input = col.children[1];
           if (input.value.length == 0){
               alert('Please fill in existing attributes');
               return
           }
       }
    }
     */


    let inputs = attributeForm.find('input');
    console.log(inputs);

    for (let input of inputs){
        if (!($(input).val())){
            alert('Please fill in existing attributes');
            return
        }
    }

    let rowDiv = $('<div>', {
        class: 'row'
    }).appendTo(attributeForm);

    let attributeColDiv = $('<div>', {
        class: 'col'
    }).appendTo(rowDiv);

    $("<label>").text('Attribute Name').appendTo(attributeColDiv);
    let attributeInput = $("<input>", {
        class: 'form-control',
        name: 'goodsAttributes['+i+'][title]',
    }).appendTo(attributeColDiv);


    let valueColDiv = $('<div>', {
        class: 'col'
    }).appendTo(rowDiv);

    $("<label>").text('Attribute Value').appendTo(valueColDiv);
    let valueInput = $("<input>", {
        class: 'form-control',
        name: 'goodsAttributes['+i+'][value]',
    }).appendTo(valueColDiv);

    // $('<button>', {
    //     class: 'col btn btn-primary',
    //     text: 'Delete attribute'
    // }).appendTo(rowDiv).onclick(function (){
    //     //let relatedInputs = $(this).siblings('input')
    // })


    /*
    let attributeInput = document.createElement('input');
    attributeInput.classList.add('form-control');
    attributeInput.setAttribute('name', 'goodsAttributes['+i+'][title]');
    let attributeColDiv = document.createElement('div')
    attributeColDiv.classList.add('col')
    let attributeLabel = document.createElement('label');
    attributeLabel.innerText = 'Attribute Name'

    let valueInput = document.createElement('input');
    valueInput.classList.add('form-control');
    valueInput.setAttribute('name', 'goodsAttributes['+i+'][value]');
    let valueColDiv = document.createElement('div');
    valueColDiv.classList.add('col');
    let valueLabel = document.createElement('label');
    valueLabel.innerText = 'Attribute Value'

    let rowDiv = document.createElement('div');
    rowDiv.classList.add('row');

    attributesDiv.appendChild(rowDiv);
        rowDiv.appendChild(attributeColDiv);
            attributeColDiv.appendChild(attributeLabel);
            attributeColDiv.appendChild(attributeInput);
        rowDiv.appendChild(valueColDiv);
            valueColDiv.appendChild(valueLabel);
            valueColDiv.appendChild(valueInput);

            i++;

     */
    i++
}

function uploadFiles(){

}

function renderAttributeForm()
{
    attributeForm.innerHTML = '';
    let categoryId = categoryPicker.val();
    $('<p><h2>Attributes</h2></p>').appendTo(attributeForm);

    $.ajax({
        url: '/attribute/get-category-attributes',
        method: 'get',
        data: {
            'id': categoryId,
            'goodsId': goodsId
        },
        success: function (data) {
            console.log(data);
            for (let item of data) {
                renderAttributeInput(item);
            }
            // switch (data)
        }
    })
}

function renderAttributeInput(item)
{
    let attributeDiv = $('<div>').appendTo(attributeForm);
    let attributeLabel = $('<label>').appendTo(attributeDiv);
    let errorLabel = $('<div class="help-block">');
    let tag = '';
    let options = [];
    let eventType = '';
    attributeLabel.text(item.name);
    let attributeInput;

    // default validator
    let validator = function (){return true};
    switch (item.type){
        case 0:
            tag = '<input type="text">';
            eventType = 'input'
            break;
        case 1:
            tag = '<input type="text">';
            eventType = 'input';
            validator = function () {
                return /^\d*$/.test(attributeInput.val());
            };
            break;
        case 2:
            tag = '<input type="text">';
            eventType = 'input';
            validator = function () {
                return /^\d*[.,]?\d*$/.test(attributeInput.val());
            };
            break;
        case 3:
            tag = '<select>';
            eventType = 'change';
            options[0] = 'Ні';
            options[1] = 'Так';
            break;
        case 4:
            tag = '<select>';
            eventType = 'change';
            // gives values, retreived from item to hydrate options
            for (let definition of item.definitions) {
                options[definition.id] = definition.value;
            }
            break;
        default:
            console.log('asdsadadasdad')
    }

    // renders input based on tag
    attributeInput = $(tag).appendTo(attributeDiv);
    attributeInput.addClass('form-control')
    attributeInput.on(eventType, () => {
        if (!validator()){
            submitButton.disabled = true;
            errorLabel.text('The ' + item.name + ' is not supposed to have such value. Try a number, perhaps?');
        } else {
            errorLabel.text('');
            globalValidate();
        }
    })

    attributeValidators[validatorCount] = validator;
    validatorCount++;

    attributeInput.attr('name', 'GoodsAttributeValue[' + item.id + ']');
    if (tag === '<input type="text">' && item.value != null){
        attributeInput.val(item.value.value)
    }

    // populate the select with options
    if (tag === '<select>'){
        let sel = false;
        for (let optionsKey in options) {
            let option = $('<option value="' + optionsKey + '">').text(options[optionsKey]).appendTo(attributeInput);
            if (!sel && (optionsKey == null || optionsKey === item.value?.value)){
                option.attr('select', '');
                sel = true;
            }
        }
    }
    
    errorLabel.appendTo(attributeDiv);
}

function globalValidate()
{
    let validated = true;
    for (let attributeValidator of attributeValidators) {
        if (!attributeValidator()){
            validated = false;
            break;
        }
    }
    if (validated) {
        submitButton.disabled = false;
    }
}
