<?php 
    include_once('../utils/session.php');
    include_once('../database/connection.db.php');
    include_once('../database/faq.class.php');
?>

<?php function drawFAQList($faqs) { ?>
    <main>
        <div id="faq-page">
            <h1>Frequently Asked Questions</h1>
            <ul id="faq-list">
                <?php foreach($faqs as $faq)
                    drawFAQ($faq);
                ?>
            </ul>
            <button type="button" class="fetch-more">
                Fetch more
            </button>
        </div>
    </main>
<?php } ?>

<?php function drawFAQ($faq) { ?>
    <li class="faq-element">
        <input id="cb<?=$faq->id?>" type="checkbox" class="faq-element-checkbox">
        <label class="faq-element-header" for="cb<?=$faq->id?>">
            <i class="fa-solid fa-chevron-down"></i>
            <h2 class="faq-element-question">
                <?=$faq->question?>
            </h2>
        </label>
        <p class="faq-element-answer">
            <?=$faq->answer?>
        </p>
    </li>
<?php } ?>