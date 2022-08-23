
var creation = 0;
var form = document.querySelector('form');

/*

<div class="checkBoxContainer">
    <p>Please select:</p>
    <input type="checkbox" name="all" value="All products">
    <label id="check">All products</label><br>
    <input type="checkbox" name="select" value="I want to select">
    <label id="check">Selected products</label><br>
</div>

*/
function createCheck(form)
{
    var div = document.createElement('div');
    div.className = 'checkBoxContainer';
    
    var p = document.createElement('p');
    var text = document.createTextNode('Please select:');
    p.appendChild(text);
    var all = document.createElement('input');
    all.type = 'checkbox';
    all.name = 'all';
    all.value = 'All products';

    var label = document.createElement('label');
    label.id = 'check';
    text = document.createTextNode('All Products');
    label.appendChild(text);

    br = document.createElement('br');
    var select = document.createElement('input');
    select.type = 'checkbox';
    select.name = 'select';
    select.value = 'Selection';

    var label2 = document.createElement('label');
    label2.id = 'check';
    text = document.createTextNode('Selected Products');
    label2.appendChild(text);

    br2 = document.createElement('br');

    div.appendChild(p);
    div.appendChild(all);
    div.appendChild(label);
    div.appendChild(br);
    div.appendChild(select);
    div.appendChild(label2);
    div.appendChild(br2);
    insertAfter(div, form);
}

function disable()
{
    var one = document.getElementsByName('all')[0];
    var two = document.getElementsByName('selected')[0];

    if(one.checked == true)
    {
        two.disabled = true;
    }
    if(two.checked == true)
    {
        two.disabled = true;
    }
}

document.getElementsByTagName('select')[0].addEventListener('change', () =>
{
    var item = document.getElementsByTagName('select')[0].value;
    if(item == 'pushProducts' && creation == 0)
    {
        createCheck(form);
        creation++;
    }
    else
    {
        if(creation == 1)
        {
            var element = document.getElementsByClassName('checkBoxContainer')[0];
            element.remove();
            creation--;
        }
    }
});

function insertAfter(newNode, referenceNode) 
{
    referenceNode.parentNode.insertBefore(newNode, referenceNode.nextSibling);
}