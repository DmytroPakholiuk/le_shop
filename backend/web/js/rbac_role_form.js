let childMap = {};
let permissionSearch = $('#permissionSearch');
let permissionItems = $('.permission-item');

populateChildrenMap()

function search(){
    let query = permissionSearch.val();
    for (let permission of permissionItems) {
        permission = $(permission)
        if (query !== '' && permission.html().toLowerCase().includes(query.toLowerCase())){
            permission.css('background-color', '#c9ffd7')
        } else {
            permission.css('background-color', '')
        }
    }
}

function populateChildrenMap()
{
    let i = 0;
    let names = {};
    for (const permissionItem of permissionItems) {
        if ($(permissionItem).children('input').is(':checked')){
            let text = $(permissionItem).children('label').text();
            if (text.includes(':')){
                text = text.split(':')[0];
            }
            text.trim();
            names[i] = text;
            i++;
        }
    }
    $.ajax({
        'url': '/rbac/role/get-all-children-permissions',
        'method': 'GET',
        'data': {
            // 1: '',
            'names': names
        },
        'success': function (ressponse){
            childMap = ressponse;
            paintSelected();
        }
    })
}

function paintSelected()
{
    let i = 0;
    let paintNames = [];
    for (let childMapKey in childMap) {
        paintNames[i] = childMapKey;
        i++;
        for (let name in childMap[childMapKey]) {
            paintNames[i] = name;
            i++;
        }
    }
    eachitem: for (let permission of permissionItems) {
        if (paintNames.length === 0){
            permission = $(permission)
            permission.css('color', '');
            continue eachitem;
        }
        for (let paintName of paintNames) {
            permission = $(permission)
            if (paintName !== '' && permission.html().toLowerCase().includes(paintName.toLowerCase())) {
                permission.css('color', 'blue');
                continue eachitem;
            } else {
                permission.css('color', '')
            }
        }
    }
}

function repaintSelection(name)
{
    let selectedElement = $('#Permissions\\[' + name + '\\]')
    if (selectedElement.is(':checked')){
        selectedElement.prop('disabled', true);
        $.ajax({
            'url': '/rbac/role/get-all-children-permissions',
            'method': 'GET',
            'data': {
                'names': {0: name}
            },
            'success': function (ressponse){
                childMap[name] = ressponse[name];
                paintSelected();
                selectedElement.prop('disabled', false);
            }
        })
    } else {
        delete childMap[name];
        paintSelected();
    }
}





