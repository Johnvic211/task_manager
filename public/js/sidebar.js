var url = window.location.href
var first = document.getElementById('first')
var second = document.getElementById('second')
var third = document.getElementById('third')

if(url.includes("\/tasks")){
    first.classList.add('active');
} else if(url.includes('published-task') && second){
    second.classList.add('active');
} else if(url.includes('profile')){
    third.classList.add('active');
} else {
    first.classList.add('active');
}
