function createTA(classNamePrev, classNameCurrent, text = '', name = '', vName = '')
{
    if(text == '' || name == '')
    {
        return null;
    }
    else
    {
        let form = document.getElementById('form');

        let div = document.createElement('div');
        div.className = 'item';

        what = document.createElement('textarea');
        what.className = 'typeE';
        what.readOnly = true;
        what.value = vName;

        prev = document.createElement('textarea');
        prev.className = classNamePrev;
        prev.readOnly = true;
        prev.value = text;

        //check if container to be created is in the required title
        // code //

        current = document.createElement('textarea');
        current.className = classNameCurrent;
        current.value = text;
        current.name = name;

        div.appendChild(what);
        div.appendChild(prev);
        div.appendChild(current);

        form.appendChild(div);
        main = document.getElementById("main");

        main.appendChild(form);
    }
}

function createPLV(t1, t2, t3, t4, sku)
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
    form.action = 'editProducts.php';
    let div = document.createElement('button');

    div.className = 'fullsize';
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