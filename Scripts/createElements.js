let require = ['title', 'sku', 'groupingCode', 'variantCode', 'costPrice', 'sellingPrice', 'optionName', 'optionValue'];

function createTA(classNamePrev, classNameCurrent, text = '', name = '')
{
    console.log(text);
    console.log(name);
    if(text == '' || name == '')
    {
        return null;
    }
    else
    {
        let div = document.createElement('div');

        prev = document.createElement('textarea');
        prev.className = classNamePrev;
        prev.readOnly = true;
        prev.value = text;

        //check if container to be created is in the required title
        // code //

        current = document.createElement('textarea');
        current.className = classNameCurrent;
        current.name = name;
        current.value = text;

        div.appendChild(prev);
        div.appendChild(current);

        main = document.getElementById("main");

        main.appendChild(div);
    }
}