$(document).ready(()=>
{
    document.getElementById('form').addEventListener('submit', ()=>
    {
        //gets the active;
        let active = document.querySelector('.act');
        
        if(active.checked == true)
        {
            active.value = 'true';
        }
        else if(active.checked == false)
        {
            active.value = 'false';
            console.log(active);
        }
    });
});