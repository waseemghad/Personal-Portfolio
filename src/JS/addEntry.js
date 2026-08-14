let form = document.querySelector('form');

let clearBtn = document.getElementById('clear');
let postBtn = document.getElementById('post');
let prvwBtn = document.getElementById('preview');

let titleBox = document.getElementById('title');
let blogBox = document.getElementById('textbox');

let titleDiv = document.getElementById('titleDiv');
let blogDiv = document.getElementById('blogDiv');

function clearContents (e) {
    e.preventDefault();
    let doesClear = window.confirm('Are you sure you want to clear your entry and start again?');
    if (! doesClear) return;

    titleBox.value = '';
    blogBox.value = '';
}

function blankCheck (e) {
    if (titleBox.value === '' || blogBox.value === '')
    {
        e.preventDefault();
        window.alert('Please fill in both your title and blog content.');
    }
    
    if (titleBox.value === '')
        titleDiv.style.backgroundColor = '#ff0033';
    else
        titleDiv.style.backgroundColor = 'transparent';

    if (blogBox.value === '')
        blogDiv.style.backgroundColor = '#ff0033';
    else
        blogDiv.style.backgroundColor = 'transparent';
}

clearBtn.addEventListener('click',clearContents);

postBtn.addEventListener('click',blankCheck);
prvwBtn.addEventListener('click',blankCheck);