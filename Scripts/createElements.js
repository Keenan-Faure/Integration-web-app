let require = ['title', 'sku', 'groupingCode', 'variantCode', 'costPrice', 'sellingPrice', 'optionName', 'optionValue'];

function createTA(classNamePrev, classNameCurrent, text = '', name = '')
{
    if(text == '' || name == '')
    {
        return null;
    }
    else
    {
        let div = document.createElement('div');

        what = document.createElement('textarea');
        what.className = 'typeE';
        what.readOnly = true;
        what.value = name;

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

        main = document.getElementById("main");

        main.appendChild(div);
    }
}

function createPLV(t1, t2, t3, t4)
{
    /*
    <div class='fullSize'>
        <div class='entry1'></div>
        <div class='entry1' id = 'entry2'></div>
        <div class='entry1' id = 'entry3'></div>
        <div class='entry1' id = 'entry4'></div>
    </div>
    */

    let div = document.createElement('div');

    div.className = 'fullsize';

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
    main = document.getElementById("maine");

    main.appendChild(div);
}