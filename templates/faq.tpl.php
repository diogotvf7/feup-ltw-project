<?php 
    include_once('../utils/session.php');
    include_once('../database/connection.db.php');
    include_once('../database/faq.class.php');
?>

<?php function drawFAQList(PDO $db) {   
    $faqs = FAQ::fetchFAQs($db, 10, 0);
    ?><main>
        <ol id="faq-list"><?php
            foreach($faqs as $faq)
                drawFAQ($db, $faq['FAQID']);
        ?></ol>
    </main><?php
} ?>

<?php function drawFAQ($db, $id) {
    $faq = FAQ::getFAQ($db, $id);
?>
    <li class="faq-element">
        <div class="faq-element-header">
            <i class="fa-solid fa-chevron-down"></i>
            <h2 class="faq-element-question">
                <?=$faq->question?>
            </h2>
        </div>
        <p class="faq-element-answer" hidden>
            <?=$faq->answer?>
        </p>
    </li>
<?php } ?>