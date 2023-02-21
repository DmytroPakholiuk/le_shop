function addAttribute(){
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

    let attributeInput = document.createElement('input');
    attributeInput.classList.add('form-control');
    attributeInput.setAttribute('name', 'attributeName[]')
    let attributeColDiv = document.createElement('div')
    attributeColDiv.classList.add('col')
    let attributeLabel = document.createElement('label');
    attributeLabel.innerText = 'Attribute Name'

    let valueInput = document.createElement('input');
    valueInput.classList.add('form-control');
    valueInput.setAttribute('name', 'attributeValue[]');
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

}
