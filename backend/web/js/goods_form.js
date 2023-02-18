
function addAttribute(){
    let attributeInput = document.createElement('input');
    attributeInput.classList.add('form-control');
    let valueInput = document.createElement('input');
    let attributesDiv = document.getElementById('attributeForm');
    attributesDiv.appendChild(attributeInput);
    attributesDiv.appendChild(valueInput);
}
