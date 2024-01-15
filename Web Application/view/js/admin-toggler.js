class Toggler {
    static toggleEditPost(post_id) {
        var editPost = document.getElementById('edit-post-container' + post_id);
        var tablePosts = document.getElementById('table-posts');

        var editPostDisplay = window.getComputedStyle(editPost).getPropertyValue('display');
        var tablePostsDisplay = window.getComputedStyle(tablePosts).getPropertyValue('display');

        editPost.style.display = (editPostDisplay === 'none') ? 'block' : 'none';
        tablePosts.style.display = (tablePostsDisplay === 'table') ? 'none' : 'table';    }

    static toggleEditComment(comment_id) {
        var editComment = document.getElementById('edit-comment-container' + comment_id);
        var tableComments = document.getElementById('table-comments');

        var editCommentDisplay = window.getComputedStyle(editComment).getPropertyValue('display');
        var tableCommentsDisplay = window.getComputedStyle(tableComments).getPropertyValue('display');

        editComment.style.display = (editCommentDisplay === 'none') ? 'block' : 'none';
        tableComments.style.display = (tableCommentsDisplay === 'table') ? 'none' : 'table';
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