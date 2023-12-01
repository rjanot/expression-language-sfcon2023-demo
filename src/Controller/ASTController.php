<?php
declare(strict_types=1);

namespace App\Controller;

use App\Domain\FeatureFlag\Service\FeatureFlagService;
use App\Domain\Kyc\Entity\Question;
use App\Infrastructure\Symfony\ExpressionLanguage;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class ASTController extends AbstractController
{
    #[Route('/abstract-syntax-tree/questions', name: 'ast-questions')]
    #[IsGranted('ROLE_USER')]
    public function __invoke(EntityManagerInterface $entityManager, ExpressionLanguage $expressionLanguage)
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
