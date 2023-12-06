<?php
declare(strict_types=1);

namespace App\Controller;

use App\Domain\Kyc\Entity\Question;
use App\Infrastructure\Symfony\QuestionExpressionLanguage;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class QuestionManagementController extends AbstractController
{
    #[Route('/question-management', name: 'question-management')]
    #[IsGranted('ROLE_USER')]
    public function index(EntityManagerInterface $entityManager, QuestionExpressionLanguage $expressionLanguage)
    {
        /** @var Question[] $questions */
        $questions = $entityManager->getRepository(Question::class)->findAll();

        return $this->render(
            'question-management/index.html.twig',
            ['questions' => $questions]
        );
    }

    #[Route('/question-management/{id}', name: 'question-edit')]
    #[IsGranted('ROLE_USER')]
    public function edit(int $id, EntityManagerInterface $entityManager, QuestionExpressionLanguage $questionExpressionLanguage, Request $request)
    {
        /** @var Question $question */
        $question = $entityManager->getRepository(Question::class)->find($id);

        $formBuilder = $this->createFormBuilder($question);
        $formBuilder->add('question', TextType::class, ['label' => 'Question label']);
        $formBuilder->add('conditionAlgorithm', TextareaType::class, ['label' => 'Condition']);

        $form = $formBuilder->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('question-management');
        }

        return $this->render(
            'question-management/edit.html.twig',
            [
                'form' => $form->createView(),
                'functions' => array_map(
                    static function($functionName) {
                        return ['displayText' => '𝑓 '.$functionName.'()', 'text' => $functionName.'()'];
                    },
                    array_keys($questionExpressionLanguage->getFunctions())
                ),
                'variables' => [['displayText' => '𝑣 question', 'text' => 'question'], ['displayText' => '𝑣 user', 'text' => 'user']]
            ]
        );
    }
}
