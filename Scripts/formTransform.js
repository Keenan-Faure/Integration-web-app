$(document).ready(()=>
{
    document.getElementById('form').addEventListener('submit', ()=>
    {
        let description = document.getElementById('holder');
        let text = '';
        let Nodes = document.querySelector('.longDescriptionContainer').children;
        for(let i = 1; i < Nodes.length; ++i)
        {
            text = text + Nodes[i].outerHTML;
        }
        description.value = text;

        //gets the active;
        let active = document.querySelector('.act');
        console.log(active.checked);
        if(active.checked == true)
        {
            active.value = 'true';
        }
        else
        {
            active.value = 'false';
        }
    });
});