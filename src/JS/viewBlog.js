let BtnArr = document.querySelectorAll('button');
let lastClickedButton = null;
let lastCommentSection = null;

let previewing = document.body.dataset.preview === 'true'; // if user is previewing


function CommentClick (e) {

    let button = e.target;
    if (button.id === 'addPostBtn' || button.id === 'submitCommBtn' || button.id === 'loginBtn')
        return;

    e.preventDefault();

    let existingBox = document.getElementById('commBox');

    // Remove existing comment box and section
    if (existingBox) existingBox.remove();
    if (lastCommentSection) lastCommentSection.remove();

    // Same button clicked: close the box
    if (lastClickedButton === button) {
        lastClickedButton = null;
        lastCommentSection = null;
        return;
    }

    // Different button: open new
    
    let postSection = button.parentNode.parentNode;
    let postId = postSection.getAttribute('data-post-id');
    
    let commentForm = document.createElement('form');
    commentForm.id = 'commBox';
    commentForm.action = 'submitComment.php';
    commentForm.method = 'post';
    
    // Hidden input for postId, sent to server when a commet is submitted
    let postIdInput = document.createElement('input');
    postIdInput.type = 'hidden';
    postIdInput.name = 'postId';
    postIdInput.value = postId;
    
    let commentSection = document.createElement('section');
    commentSection.className = 'commentsDisplay';
    
    let textBox = document.createElement('textarea');
    textBox.name = 'userComment';
    textBox.placeholder = "Type your comment (make sure you're logged in).";
    textBox.required = true;
    
    let submitCommBtn = document.createElement('button');
    submitCommBtn.type = 'submit';
    submitCommBtn.className = 'buttonClass';
    submitCommBtn.textContent = 'Submit';

    commentForm.appendChild(postIdInput);
    commentForm.appendChild(textBox);
    commentForm.appendChild(submitCommBtn);
    
    lastClickedButton = button;
    lastCommentSection = commentSection;
    
    // Fetch comments from 'COMMENTS'
    fetch('getComments.php?postId=' + postId)
        .then(function(response) {  // waits for a 'response' (the HTML string), conv to a text string
            return response.text();
        })
        .then(function(comments) {
            // Parse delimited text and build DOM
            let commentBlocks = comments.trim().split('||');  // Split comments by ||
            
            commentBlocks.forEach(function(block) {
                if (block === '') return;  // Skip empty blocks
                
                let parts = block.split('|');
                let name = parts[0];
                let text = parts[1];
                let date = parts[2];
                
                // Create comment div
                let commentDiv = document.createElement('div');
                commentDiv.className = 'comment';
                
                // Create name paragraph with strong tag
                let nameP = document.createElement('p');
                let strong = document.createElement('strong');
                strong.textContent = name + ':';
                nameP.appendChild(strong);
                
                // Create comment text paragraph
                let contentP = document.createElement('p');
                contentP.textContent = text;  // Preserves newlines
                
                // Create timestamp
                let timeSmall = document.createElement('small');
                timeSmall.textContent = date;
                
                // Append all to comment div
                commentDiv.appendChild(nameP);
                commentDiv.appendChild(contentP);
                commentDiv.appendChild(timeSmall);
                
                // Append to comments section
                commentSection.appendChild(commentDiv);
            });
            
            // Append section and form after comments are loaded
            postSection.appendChild(commentSection);
            postSection.appendChild(commentForm);
        })
        .catch(function(error) {
            console.error('Error fetching comments:', error);
        });
}

if (! previewing) {
    BtnArr.forEach(button => {
        button.addEventListener('click', CommentClick);
    });
}