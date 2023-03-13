let i = 0;

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

    let attributeForm = $('#attributeForm');

    let inputs = attributeForm.find('input');
    for (let input of inputs){
        if (!input.val()){
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
