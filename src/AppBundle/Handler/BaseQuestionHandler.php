<?php


namespace AppBundle\Handler;


use AppBundle\Entity\BaseQuestion;
use AppBundle\Entity\TextAreaQuestion;
use AppBundle\Entity\VariantQuestion;
use AppBundle\Form\BaseQuestionForm;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class BaseQuestionHandler extends AbstractHandler
{
    protected function getEntityClass()
    {
        return BaseQuestion::class;
    }

    protected function getFormType()
    {
        return new BaseQuestionForm();
    }

    public function post(array $parameters)
    {
        $baseQuestion = new BaseQuestion();
        $baseQuestion->setCreatedBy($this->getUser());

        /** @var BaseQuestion $baseQuestion */
        $baseQuestion = $this->processForm($baseQuestion, $parameters, 'POST');

        switch ($baseQuestion->getType())
        {
            case BaseQuestion::TEXT_AREA:
                if (!isset($parameters['text_limit'])) {
                    throw new BadRequestHttpException('Text limit required.');
                }
                $this->createTextAreaQuestion($baseQuestion, $parameters['text_limit']);
                break;
            case BaseQuestion::CHOICE;
                if (!isset($parameters['correct_choices'])) {
                    throw new BadRequestHttpException('Number of correct choices needed.');
                }
                $this->createChoiceQuestion($baseQuestion, $parameters['correct_choices']);
                break;
        }
        $this->em->flush();

        return $baseQuestion;
    }

    private function createTextAreaQuestion(BaseQuestion $baseQuestion, $textLimit)
    {
        $question = new TextAreaQuestion();
        $question->setTextLimit($textLimit)
            ->setBaseQuestion($baseQuestion);

        $this->em->persist($question);
    }

    private function createChoiceQuestion(BaseQuestion $baseQuestion, $correctChoices)
    {
        $question = new VariantQuestion();
        $question->setBaseQuestion($baseQuestion)
            ->setCorrectChoices($correctChoices);

        $this->em->persist($question);
    }


}