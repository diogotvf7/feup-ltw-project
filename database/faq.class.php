<?php
  declare(strict_types = 1);

  class FAQ {
    public int $id;
    public string $question;
    public string $answer;
    
    public function __construct(int $id, string $question, string $answer)
    {
        $this->id = $id;
        $this->question = $question;
        $this->answer = $answer;
    }

    static function fetchFAQs(PDO $db, int $ammount, int $page) {
      $stmt = $db->prepare('
        SELECT FAQID, Question, Answer
        FROM FAQ
        ORDER BY 1
        LIMIT ? OFFSET ?
      ');

      $stmt->execute(array($ammount, $page * $ammount));
  
      $rawData = $stmt->fetchAll(PDO::FETCH_OBJ);

      $faqs = array();
      foreach ($rawData as $faq)
        array_push($faqs, new FAQ(
          $faq->FAQID,
          $faq->Question,
          $faq->Answer,
        ));

      return $faqs;
    }

    static function getFAQ(PDO $db, int $id) : FAQ {
      $stmt = $db->prepare('
        SELECT FAQID, Question, Answer
        FROM FAQ
        WHERE FAQID = ?
      ');

      $stmt->execute(array($id));
      $faq = $stmt->fetch();
      
      return new FAQ(
        $faq['FAQID'],
        $faq['Question'],
        $faq['Answer'],
      );
    }

    static function createFaq(PDO $db, string $question, string $answer) {
      $stmt = $db->prepare('
        INSERT INTO FAQ (Question, Answer)
        VALUES (?, ?)
      ');

      $stmt->execute(array($question, $answer));
    }

    function toJson() {
      return json_encode($this);
    }
  }
?>