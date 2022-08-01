var btn = document.querySelector('.next');
var background = document.querySelector('.background');
var background2 = document.querySelector('.backgroundtwo');

function swap()
{
    background.classList.remove('fade-in');
    background.classList.add('fade-out');
    setTimeout(()=>
    {
        document.querySelector('.next').style.opacity = 0;
        document.querySelector('.nextBtn').style.opacity = 0;
        background.style.zIndex = -10;
        document.querySelector('.next2');
        document.querySelector('.nextBtn2');

    }, 300); //0.3s
    setTimeout(()=>
    {
        background2.classList.add('fade-in');
        background2.style.zIndex = 10;
    }, 500); //0.5s
}
function swap2()
{

    background2.classList.remove('fade-in');
    background2.classList.add('fade-out');
    background2.style.zIndex = -10;

    background.style.zIndex = 10;
    background.classList.remove('fade-out');
    background.classList.add('fade-in');

    document.querySelector('.next').style.opacity = 10;
    document.querySelector('.nextBtn').style.opacity = 1;
}

//<div class='container'><p>Database1</p></div>

function createContainer(name)
{
    main = document.getElementById('c1');
    if(name != null)
    {
        var container = document.createElement('div');
        container.classList.add('container');

        var word = document.createElement('p');
        word.appendChild(document.createTextNode(name));

        container.appendChild(word);
        container.classList.add('fade-in');
        main.appendChild(container);
    }
}

/*
var side = "right";

document.addEventListener('keydown', (event)=>
{
    if(event.key == "ArrowRight")
    {
        swap();
        side = "left";
    }
    if(event.key == "ArrowLeft")
    {
        swap2();
        side = "right";
    }
});

*/

