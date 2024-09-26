<?php
session_start();
require './../database/databaseConnect.php';

// Vérifiez si l'utilisateur est connecté
if (!isset($_SESSION['mail'])) {
    header('Location: ./../index.php'); // Redirige vers la page de connexion si non connecté
    exit();
}

// Récupérez l'ID de l'utilisateur à partir de la session
$mail = $_SESSION['mail'];
$sql = $conn->prepare("SELECT id, prenom FROM Compte WHERE email = :email");
$sql->bindParam(':email', $mail);
$sql->execute();
$user = $sql->fetch(PDO::FETCH_OBJ);
$user_id = $user->id; // Récupère l'ID de l'utilisateur
$user_name = $user->prenom;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hanotan-e</title>
    <link rel="stylesheet" href="./../front/app.css">
</head>
<body>

<nav class="navbar">
    <div class="navbar-container">
        <div class="logo">
            <img src="./../img/Hanontan-e.png" alt="logo">
        </div>
        <h1 class="navbar-title">HANONTAN-e</h1>
        
        <div class="navbar-links">
            <img src="./../img/user.png" alt="user">
            <span class="navbar-user"><strong><?php echo htmlspecialchars($user_name); ?></strong></span>
        </div>
        <div id="deconnexion">
            <a href="./../php/deconnexion.php">
                <button>Se déconnecter</button>
            </a>
        </div>

    </div>
</nav>

<div class="container">
    <h2 class="bienvenue">BIENVENUE</h2>

    <!-- Create Publication Form -->
    <div class="form-group">
        <form id="createForm">
            <label for="content">Ametraka fanontaniana:</label>
            <textarea id="content" name="content" rows="4" required></textarea>
            <button type="submit">Hanontany</button>
        </form>
    </div>

    <!-- Display Publications -->
    <div class="publications" id="publications">
        <h2>All Publications</h2>
        <!-- Publications will be loaded here via JavaScript -->
    </div>
</div>


<script>
   function fetchComments(publicationId) {
    fetch(`./../data/comments/read.php?publication_id=${publicationId}`)
        .then(response => response.json())
        .then(data => {
            const commentsListDiv = document.getElementById(`comments-list-${publicationId}`);
            commentsListDiv.innerHTML = ''; // Efface les anciens commentaires
            data.forEach(comment => {
                const commentHTML = `
                    <div class="comment" id="comment-${comment.id}">
                        <h4>${comment.prenom}</h4>
                        <p>${comment.contenu}</p>
                        <div id="comment-reactions-${comment.id}">
                            <!-- Les réactions seront chargées ici -->
                        </div>
                        <button onclick="handleCommentReaction(${comment.id}, 'like')">J'aime</button>
                        <button onclick="handleCommentReaction(${comment.id}, 'dislike')">Je n'aime pas</button>
                    </div>
                `;
                commentsListDiv.innerHTML += commentHTML;
                fetchCommentReactions(comment.id); // Charger les réactions pour chaque commentaire
            });
        })
        .catch(error => {
            console.error('Erreur lors de la récupération des commentaires :', error);
        });
}


    function fetchPublications() {
    fetch('./../data/read.php')
        .then(response => response.json())
        .then(data => {
            const publicationsDiv = document.getElementById('publications');
            publicationsDiv.innerHTML = '';  // Efface les anciennes publications
            data.forEach(publication => {
                const publicationHTML = `
                    <div class="publication" id="${publication.id}">
                        <h3>${publication.prenom}</h3>
                        <p class="pubContains">${publication.contenu}</p>
                        ${publication.id_compte == <?php echo $user_id; ?> ? `
                        <div class="actions">
                            <button onclick="deletePublication(${publication.id})">Supprimer</button>
                            <button onclick="editPublication(${publication.id}, '${encodeURIComponent(publication.contenu)}')">Modifier</button>
                        </div>` : ''}
                        <div id="reactions-${publication.id}" style="display: none;">
                            <!-- Les réactions seront chargées ici -->
                        </div>
                        <button onclick="handleReaction(${publication.id}, 'like')">J'aime</button>
                        <button onclick="handleReaction(${publication.id}, 'dislike')">Je n'aime pas</button>
                        <button onclick="toggleReactions(${publication.id})">Voir les réactions</button>
                        <div id="reaction-users-${publication.id}" class="reaction-users" style="display: none;">
                            <!-- Les utilisateurs ayant réagi seront affichés ici -->
                        </div>
                        <button onclick="toggleComments(${publication.id})">Voir les commentaires...</button>
                        <div class="comments-section" id="comments-section-${publication.id}" style="display: none;">
                            <h4>Commentaires</h4>
                            <div id="comments-list-${publication.id}">
                                <!-- Les commentaires seront chargés ici -->
                            </div>
                            <form id="addCommentForm-${publication.id}" action="./../data/comments/create.php" method="post">
                                <input type="hidden" value="${publication.id}" name="publication_id">
                                <input type="hidden" value="<?php echo $user_id; ?>" name="user_id">
                                <textarea id="comment-input-${publication.id}" name="content" rows="2" required></textarea>
                                <button type="submit">Ajouter un commentaire</button>
                            </form>
                        </div>
                    </div>
                `;
                publicationsDiv.innerHTML += publicationHTML;
                fetchComments(publication.id); // Charger les commentaires pour chaque publication
                fetchReactions(publication.id); // Charger les réactions pour chaque publication
            });
        });
}
function toggleReactions(publicationId) {
    const reactionUsersDiv = document.getElementById(`reactions-${publicationId}`);
    if (reactionUsersDiv.style.display === 'none') {
        reactionUsersDiv.style.display = 'block';
    } else {
        reactionUsersDiv.style.display = 'none';
    }
}
    // Création d'une nouvelle publication
    document.getElementById('createForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const content = document.getElementById('content').value;

        fetch('./../data/create.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `content=${encodeURIComponent(content)}&user_id=${<?php echo $user_id; ?>}`
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message);
            fetchPublications(); // Recharger les publications
        });
    });

    function toggleComments(publicationId) {
        const commentsSection = document.getElementById(`comments-section-${publicationId}`);
        if (commentsSection.style.display === 'none') {
            commentsSection.style.display = 'block';
            fetchComments(publicationId); // Charger les commentaires uniquement si le bloc est affiché
        } else {
            commentsSection.style.display = 'none';
        }
    }

    // Suppression d'une publication
    function deletePublication(id) {
        if (confirm("Voulez-vous vraiment supprimer cette publication ?")) {
            fetch('./../data/delete.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `id=${id}`
            })
            .then(response => response.json())
            .then(data => {
                alert(data.message);
                fetchPublications(); // Recharger les publications
            });
        }
    }

    // Modification d'une publication
    function editPublication(id, content) {
        const newContent = prompt("Modifier le contenu", decodeURIComponent(content));

        if (newContent !== null) {
            fetch('./../data/update.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `id=${id}&content=${encodeURIComponent(newContent)}`
            })
            .then(response => response.json())
            .then(data => {
                alert(data.message);
                fetchPublications(); // Recharger les publications
            });
        }
    }

    // Suppression d'un commentaire
    function deleteComment(id) {
        if (confirm("Voulez-vous vraiment supprimer ce commentaire ?")) {
            fetch('./../data/comments/delete.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `id=${id}`
            })
            .then(response => response.json())
            .then(data => {
                alert(data.message);
                fetchComments(id); // Recharger les commentaires
                fetchPublications(); // Recharger les publications
            });
        }
    }

    // Modification d'un commentaire
    function editComment(id, content) {
        const newContent = prompt("Modifier le contenu", decodeURIComponent(content));

        if (newContent !== null) {
            fetch('./../data/comments/update.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `id=${id}&content=${encodeURIComponent(newContent)}`
            })
            .then(response => response.json())
            .then(data => {
                alert(data.message);
                fetchComments(id); // Recharger les commentaires
            });
        }
    }

    // Gestion des réactions pour les publications
    function handleReaction(id, type) {
        const userId = <?php echo $user_id; ?>;

        fetch('./../data/reactionPub/create.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `id_publication=${id}&id_compte=${userId}&type=${type}`
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message);
            fetchReactions(id); // Recharger les réactions
        });
    }
  
    function fetchReactions(publicationId) {
    fetch(`./../data/reactionPub/read.php?publication_id=${publicationId}`)
        .then(response => response.json())
        .then(data => {
            const reactionsDiv = document.getElementById(`reactions-${publicationId}`);
            const likedBy = data.liked_by.length ? `Aimé par: ${data.liked_by.join(', ')}` : 'Aucun j\'aime';
            const dislikedBy = data.disliked_by.length ? `N\'aime pas: ${data.disliked_by.join(', ')}` : 'Aucun je n\'aime pas';

            reactionsDiv.innerHTML = `
                <p>${data.likes} j'aime, ${data.dislikes} je n'aime pas</p>
                <p>${likedBy}</p>
                <p>${dislikedBy}</p>
            `;
        })
        .catch(error => {
            console.error('Erreur lors de la récupération des réactions :', error);
        });
}


    // Gestion des réactions pour les commentaires
    function handleCommentReaction(commentId, type) {
    const formData = new FormData();
    formData.append('comment_id', commentId);
    formData.append('type', type);
    formData.append('user_id', <?php echo $user_id; ?>);

    fetch('./../data/reactionComm/create.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            fetchCommentReactions(commentId); // Mettre à jour les réactions du commentaire après ajout
        } else {
            console.error('Erreur lors de l\'ajout de la réaction :', data.message);
        }
    })
    .catch(error => {
        console.error('Erreur lors de l\'ajout de la réaction :', error);
    });
}

    function fetchCommentReactions(commentId) {
    fetch(`./../data/reactionComm/read.php?comment_id=${commentId}`)
        .then(response => response.json())
        .then(data => {
            const reactionsDiv = document.getElementById(`comment-reactions-${commentId}`);
            const likedBy = data.liked_by.length ? `Aimé par: ${data.liked_by.join(', ')}` : 'Aucun j\'aime';
            const dislikedBy = data.disliked_by.length ? `N\'aime pas: ${data.disliked_by.join(', ')}` : 'Aucun je n\'aime pas';

            reactionsDiv.innerHTML = `
                <p>${data.likes} j'aime, ${data.dislikes} je n'aime pas</p>
                <p>${likedBy}</p>
                <p>${dislikedBy}</p>
            `;
        })
        .catch(error => {
            console.error('Erreur lors de la récupération des réactions :', error);
        });
}


    // Chargement initial des publications lors du chargement de la page
    document.addEventListener('DOMContentLoaded', fetchPublications);
</script>

</body>
</html>
