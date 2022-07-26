function createTA(classNamePrev, classNameCurrent, text = '')
{
    if(text == '')
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

        current = document.createElement('textarea');
        current.className = classNameCurrent;
        current.value = text;

        div.appendChild(prev);
        div.appendChild(current);

        main = document.getElementById("main");

        main.appendChild(div);
    }
}