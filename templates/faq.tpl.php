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

<?php function drawNewFaqPage() { ?>
    <main id="new-faq-page">
        <form id="new-faq" method="post" action="../actions/submit_faq.php"> 
            <h3>New faq</h3>
            <fieldset>
                <legend id = description>Fill in the following fields to create a new faq</legend>
                <input placeholder="Question" type="text" name="faq_question" tabindex="1" maxlength="27" required autofocus>
                <textarea placeholder="Type the answer here...." name="faq_answer" tabindex="2" required></textarea>
                <button id="submit" type="submit" >Submit</button>
            </fieldset>        
        </form>
    </main>
<?php } ?>