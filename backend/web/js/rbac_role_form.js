let childMap = {};
let permissionSearch = $('#permissionSearch');
let permissionItems = $('.permission-item');

// populateChildrenMap()
// paintSelected()

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
    console.log(childMap)
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
    console.log(paintNames)
    eachitem: for (let permission of permissionItems) {
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
//
// function repaintSelection(name)
// {
//     if
// }





