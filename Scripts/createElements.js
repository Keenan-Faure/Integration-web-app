function createTA(classNamePrev, classNameCurrent, text)
{
    let div = document.createElement('div');

    prev = document.createElement('textarea');
    prev.className = classNamePrev;
    prev.value = text;

    current = document.createElement('textarea');
    current.className = classNameCurrent;
    current.value = text;

    div.appendChild(prev);
    div.appendChild(current);

    body.appendChild(div);
}