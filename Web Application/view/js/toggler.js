class Toggler {

    static toggleCreatePost() {
        var createPost = document.getElementById('create-post-container');
        var postBlock = document.getElementById('post-block');

        // Get the property value of the display
        var createPostDisplay = window.getComputedStyle(createPost).getPropertyValue('display');
        var postBlockDisplay = window.getComputedStyle(postBlock).getPropertyValue('display');

        // Toggle the display property based on the current state
        createPost.style.display = (createPostDisplay === 'none') ? 'block' : 'none';
        postBlock.style.display = (postBlockDisplay === 'flex') ? 'none' : 'flex';
    }

    static toggleComments(post_id) {
        var commentsBlock = document.getElementById('comments-block' + post_id);

        var commentsBlockDisplay = window.getComputedStyle(commentsBlock).getPropertyValue('display');
        commentsBlock.style.display = (commentsBlockDisplay === 'none') ? 'block' : 'none';
    }

    static toggleEditPost(post_id) {
        var editPost = document.getElementById('edit-post-container' + post_id);
        var postContainer = document.getElementById('post-container' + post_id);

        var editPostDisplay = window.getComputedStyle(editPost).getPropertyValue('display');
        var postContainerDisplay = window.getComputedStyle(postContainer).getPropertyValue('display');

        editPost.style.display = (editPostDisplay === 'none') ? 'block' : 'none';
        postContainer.style.display = (postContainerDisplay === 'block') ? 'none' : 'block';
    }

    static toggleEditComment(comment_id) {
        var editComment = document.getElementById('edit-comment-container' + comment_id);
        var commentContainer = document.getElementById('comment-container' + comment_id);

        var editCommentDisplay = window.getComputedStyle(editComment).getPropertyValue('display');
        var commentContainerDisplay = window.getComputedStyle(commentContainer).getPropertyValue('display');

        editComment.style.display = (editCommentDisplay === 'none') ? 'block' : 'none';
        commentContainer.style.display = (commentContainerDisplay === 'block') ? 'none' : 'block';
    }

    static toggleEditAccount(account_id) {
        var editAccount = document.getElementById('edit-account-container' + account_id);
        var tableUserAccounts = document.getElementById('table-user-accounts');

        var editAccountDisplay = window.getComputedStyle(editAccount).getPropertyValue('display');
        var tableUserAccountsDisplay = window.getComputedStyle(tableUserAccounts).getPropertyValue('display');

        editAccount.style.display = (editAccountDisplay === 'none') ? 'block' : 'none';
        tableUserAccounts.style.display = (tableUserAccountsDisplay === 'table') ? 'none' : 'table';
    }
}