class Toggler {

    static toggleCreatePost() {
        var createPost = document.getElementById('create-post-container');
        var postBlock = document.getElementById('post-block');
        createPost.style.display = (createPost.style.display === 'none') ? 'block' : 'none';
        postBlock.style.display = (postBlock.style.display === 'flex') ? 'none' : 'flex';
    }

    static toggleComments(post_id) {
        var commentsBlock = document.getElementById('comments-block' + post_id);
        commentsBlock.style.display = (commentsBlock.style.display === 'none') ? 'block' : 'none';
    }

    static toggleEditPost(post_id) {
        var editPost = document.getElementById('edit-post-container' + post_id);
        var postContainer = document.getElementById('post-container' + post_id);
        editPost.style.display = (editPost.style.display === 'none') ? 'block' : 'none';
        postContainer.style.display = (postContainer.style.display === 'block') ? 'none' : 'block';
    }

    static toggleEditComment(comment_id) {
        var editComment = document.getElementById('edit-comment-container' + comment_id);
        var commentContainer = document.getElementById('comment-container' + comment_id);
        editComment.style.display = (editComment.style.display === 'none') ? 'block' : 'none';
        commentContainer.style.display = (commentContainer.style.display === 'block') ? 'none' : 'block';
    }
}