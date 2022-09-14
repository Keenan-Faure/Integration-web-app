function createTA(classNamePrev, classNameCurrent, text = null, name = null, vName = '', style='')
{
    let form = document.getElementById('form');

    let div = document.createElement('div');
    if(style == '')
    {
        div.className = 'item1';  
    }
    else
    {
        div.className = 'item';
    }

    what = document.createElement('textarea');
    what.className = 'typeE';
    what.readOnly = true;
    what.value = vName;

    //check if container to be created is in the required title
    // code //

    current = document.createElement('textarea');
    current.className = classNameCurrent;
    current.value = text;
    current.name = name;

    if(name != 'description')
    {
        current.id = 'shrink';
        what.id = 'shrink';
    }

    div.appendChild(what);
    div.appendChild(current);

    form.appendChild(div);
    main = document.getElementById("main");

    main.appendChild(form);
}

function createPLV(t1, t2, t3, t4, sku, skuValue)
{
    /*
    <form method='post' target='_blank' action='editProducts.php'>
        <div class='fullSize'>
            <div class='entry1'></div>
            <div class='entry1' id = 'entry2'></div>
            <div class='entry1' id = 'entry3'></div>
            <div class='entry1' id = 'entry4'></div>
        </div>
    </form>
    */
    let form = document.createElement('form');
    form.method = 'post';
    form.action = 'newView.php';
    let div = document.createElement('button');

    div.className = 'fullsize';
    div.value = skuValue;
    div.name = sku;

    //can be done in loop
    //1.) creates entry div -> 2.) creates text Node with text parameter
    //3.) Appends the text node to the entry div -> 4.) appends the entry div to the main div
    //--done--//

    let entry1 = document.createElement('div');
    entry1.className = 'entry1';
    let text = document.createTextNode(t1);
    entry1.appendChild(text);
    div.appendChild(entry1);

    let entry2 = document.createElement('div'); 
    entry2.className = 'entry1';
    entry2.id = 'entry2';
    let text2 = document.createTextNode(t2);
    entry2.appendChild(text2);
    div.appendChild(entry2);

    let entry3 = document.createElement('div'); 
    entry3.className = 'entry1';
    entry3.id = 'entry3';
    let text3 = document.createTextNode(t3);
    entry3.appendChild(text3);
    div.appendChild(entry3);

    let entry4 = document.createElement('div'); 
    entry4.className = 'entry1';
    entry4.id = 'entry4';
    let text4 = document.createTextNode(t4);
    entry4.appendChild(text4);
    div.appendChild(entry4);

    //appends to container
    form.appendChild(div);
    main = document.getElementById("maine");

    main.appendChild(form);
}

function createCLV(t1, t2, t3, t4, id)
{
    /*
    <form method='post' target='_blank' action='editCustomers.php'>
        <div class='fullSize'>
            <div class='entry1'></div>
            <div class='entry1' id = 'entry2'></div>
            <div class='entry1' id = 'entry3'></div>
            <div class='entry1' id = 'entry4'></div>
        </div>
    </form>
    */
    let form = document.createElement('form');
    form.method = 'post';
    form.action = 'editCustomers.php';
    let div = document.createElement('button');

    div.className = 'fullsize';
    div.name = id;

    //can be done in loop
    //1.) creates entry div -> 2.) creates text Node with text parameter
    //3.) Appends the text node to the entry div -> 4.) appends the entry div to the main div
    //--done--//

    let entry1 = document.createElement('div');
    entry1.className = 'entry1';
    let text = document.createTextNode(t1);
    entry1.appendChild(text);
    div.appendChild(entry1);

    let entry2 = document.createElement('div'); 
    entry2.className = 'entry1';
    entry2.id = 'entry2';
    let text2 = document.createTextNode(t2);
    entry2.appendChild(text2);
    div.appendChild(entry2);

    let entry3 = document.createElement('div'); 
    entry3.className = 'entry1';
    entry3.id = 'entry3';
    let text3 = document.createTextNode(t3);
    entry3.appendChild(text3);
    div.appendChild(entry3);

    let entry4 = document.createElement('div'); 
    entry4.className = 'entry1';
    entry4.id = 'entry4';
    let text4 = document.createTextNode(t4);
    entry4.appendChild(text4);
    div.appendChild(entry4);

    //appends to container
    form.appendChild(div);
    main = document.getElementById("maine");

    main.appendChild(form);
}

function createSumbit()
{
    let button = document.createElement('input');
    button.className = 'eButton';
    button.type = 'submit';

    form = document.getElementById('form');
    form.appendChild(button);
}


//Run-format of the functions
//getClassNames -> convertJsonToArray -> setText (Filters) -> applyText


//id is the id of the element
//either variant or general
function convertJsonToArray(texter)
{
    //converts json object into an array
    let result = [];
    for(let i in texter)
    {
        result.push([i, texter[i]]);
    }
    return result;
}
function getClassNames(text)
{
    $(document).ready(()=>
    {
        let generalClassNames = [null, null, null, 's', 'titleContainer', 'longDescriptionContainer', 'pc', 'cl', 'pt', 'vd', 'vc', 'bc', 
        'wv', 'ctp', 'sp', 'q', 'on1', 'ov1', 'on2', 'ov2', 'm1', 'm2', 'm3'];
        let valueArray = convertJsonToArray(text);
        //console.log(valueArray[valueArray.length - 1]); //23
        //console.log(generalClassNames.length); //20
        setText(generalClassNames, valueArray);
    });
}

//applies a text node to a certain element
//className => is the name of the element in HTML
//text => is the array containing the values that will be  assigned to the element
function applyText(className, Text)
{
    //queries className
    let object = document.querySelector('.' + className);
    
    //creates text node
    let text = document.createTextNode(Text);
    //objects text to parent
    object.appendChild(text);
}

//Uses parallel arrays to loop through the text array
//If it's values are part of the ignore array
//Then skip that iteration
//otherwise add the text to the class
function setText(classNames, text)
{
    let ignore = ['Token', 'Type', 'Active'];
    for(let i = 0; i < text.length; ++i)
    {
        if(ignore.includes(text[i][0]))
        {
            continue;
        }
        else if(text[i][0] == 'Description')
        {
            document.querySelector('.' + classNames[i]).insertAdjacentHTML("afterbegin", text[i][1]);
            continue;
        }
        else
        {
            if(text[i][1] == null || text[i][1] == '')
            {
                text[i][1] = null;
            }
            applyText(classNames[i], text[i][1]);
        }
    }
}