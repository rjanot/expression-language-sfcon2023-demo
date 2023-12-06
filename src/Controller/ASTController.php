<?php
declare(strict_types=1);

namespace App\Controller;

use App\Domain\Kyc\Entity\Question;
use App\Infrastructure\Symfony\QuestionExpressionLanguage;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class ASTController extends AbstractController
{
    #[Route('/abstract-syntax-tree/questions', name: 'ast-questions')]
    #[IsGranted('ROLE_USER')]
    public function __invoke(EntityManagerInterface $entityManager, QuestionExpressionLanguage $expressionLanguage)
    {
        /** @var Question[] $questions */
        $questions = $entityManager->getRepository(Question::class)->findAll();

        $enrichedQuestions = [];
        foreach ($questions as $question) {
            $enrichedQuestions[] = [
                'question' => $question,
                'ast' => $expressionLanguage->parse($question->getConditionAlgorithm(), ['user', 'question']),
            ];
        }

        return $this->render(
            'ast/questions.html.twig',
            ['questions' => $enrichedQuestions]
        );
    }
}
