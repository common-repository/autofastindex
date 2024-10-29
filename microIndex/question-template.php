<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <?php wp_head(); ?>
    <title><?php echo get_the_title($post->ID); ?> - PWA</title>
    <link rel="stylesheet" href="<?php echo plugin_dir_url(__FILE__) . 'style.css'; ?>">
    <style>
/* Global Styles */
body {
    margin: 2;
    padding: 2;
    font-family: 'Arial', sans-serif;
    background-color: #f4f4f4;
    color: #333;
    line-height: 1.6;
    height: 100%;
    width: 100%;
    overflow-x: hidden;
}

/* Container */
.pwa-content {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}

/* Header */
header {
    background: #0073e6;
    color: white;
    padding: 10px 0;
    text-align: center;
}

header h1 {
    margin: 0;
    font-size: 2em;
}

/* Navigation */
nav {
    display: flex;
    justify-content: space-around;
    background: #005bb5;
    padding: 10px 0;
}

nav a {
    color: white;
    text-decoration: none;
    padding: 10px 20px;
    font-weight: bold;
    transition: background 0.3s ease;
}

nav a:hover {
    background: #004494;
}

/* Main Content */
main {
    padding: 20px;
}

/* Footer */
footer {
    background: #0073e6;
    color: white;
    text-align: center;
    padding: 10px 0;
    position: fixed;
    bottom: 0;
    width: 100%;
}

/* Responsive Design */
@media (max-width: 768px) {
    nav {
        flex-direction: column;
    }
    
    nav a {
        text-align: center;
        padding: 15px 0;
        border-bottom: 1px solid #004494;
    }
}

@media (max-width: 480px) {
    header h1 {
        font-size: 1.5em;
    }
    
    .container {
        padding: 10px;
    }
}

        </style>
</head>
<body>

    <div class="pwa-content">
        <center><h1><?php echo get_the_title($post->ID); ?></h1></center>
        <h1>Question and Answer</h1>
        <?php 
        /*

        "qna": [
        {
            "question": "What is WordPress.?",
            "answer": "WordPress. is Welcome to."
        },
        {
            "question": "How does WordPress. Welcome?",
            "answer": "Welcome to WordPress."
        },
        {
            "question": "What is This n?",
            "answer": "This n is is yourmm first post.."
        },
        {
            "question": "How does This n is?",
            "answer": "This n is yourmm first post."
        },
        {
            "question": "What is Ejjmmmdit?",
            "answer": "Ejjmmmdit is or delete it, thnnen stasdsadrtkk writing!."
        },
        {
            "question": "How does Ejjmmmdit delete?",
            "answer": "Ejjmmmdit or delete it, thnnen stasdsadrtkk writing!"
        }
    ]

        */
        foreach($qna as $item){
            echo "<h2>" . $item['question'] . "</h2>";
            echo "<p>" . $item['answer'] . "</p>";
        }
        ?>
       
    </div>
    <a href="<?php echo $permalink; ?>">Original Content</a>

    <?php
get_footer(); // Include WordPress footer
?>
</body>
</html>
