<?php
namespace GqAus\UserBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
/**
 * Faq's
 */
class Faq
{
    /**
     * @var string
     */
    private $id;
    /**
     * @var string
     */
    private $question;
    /**
     * @var string
     */
    private $answer;
    /**
     * @var string
     */
    private $status;
    
    /**
     * Set question
     *
     * @param string $question
     * @return question
     */
    public function setQuestion($question)
    {
        $this->question = $question;

        return $this;
    }
     /**
     * Get question
     *
     * @return string 
     */
    public function getQuestion()
    {
        return $this->question;
    }
    /**
     * Set answer
     *
     * @param string $answer
     * @return answer
     */
    public function setAnswer($answer)
    {
        $this->answer = $answer;

        return $this;
    }
     /**
     * Get answer
     *
     * @return string 
     */
    public function getAnswer()
    {
        return $this->answer;
    }
      /**
     * Get id
     *
     * @return string 
     */
    public function getId()
    {
        return $this->id;
    }
     /**
     * Set status
     *
     * @param string $status
     * @return User
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string 
     */
    public function getStatus()
    {
        return $this->status;
    }

}
?>
