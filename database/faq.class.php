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

    // function save($db) {
    //   $stmt = $db->prepare('
    //     UPDATE Client SET Username = ?
    //     WHERE ClientID = ?
    //   ');

    //   $stmt->execute(array($this->username, $this->id));
    // }
    
    static function fetchFAQs(PDO $db, int $ammount, int $page) {
      $stmt = $db->prepare('
        SELECT FAQID
        FROM FAQ
        ORDER BY 1
        LIMIT ? OFFSET ?
      ');

      $stmt->execute(array($ammount, $page * $ammount - 1));
  
      return $stmt->fetchAll();
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
  }
?>