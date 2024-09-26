function toggleNavbar() {
    const navbarLinks = document.querySelector('.navbar-links');
    navbarLinks.classList.toggle('active');
}
function toggleReactions(publicationId) {
    const reactionUsersDiv = document.getElementById(`reactions-${publicationId}`);
    if (reactionUsersDiv.style.display === 'none') {
        reactionUsersDiv.style.display = 'block';
    } else {
        reactionUsersDiv.style.display = 'none';
    }
}
