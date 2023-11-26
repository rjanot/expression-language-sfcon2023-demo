<?php
declare(strict_types=1);

namespace App\Controller;

use App\Domain\FeatureFlag\Service\FeatureFlagService;
use App\Domain\Kyc\Entity\Question;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class KycFormController extends AbstractController
{
    #[Route('/', name: 'form')]
    #[IsGranted('ROLE_USER')]
    public function __invoke(EntityManagerInterface $entityManager, FeatureFlagService $featureFlagService)
    {
        /** @var Question[] $questions */
        $questions = $entityManager->getRepository(Question::class)->findQuestionsForUser($this->getUser());

        $formBuilder = $this->createFormBuilder();
        foreach ($questions as $question) {
            $formBuilder->add('question_'.$question->getId(), TextType::class, ['label' => $question->getQuestion()]);
        }

        if ($featureFlagService->isEnabledForUser('FORM_V2', $this->getUser())) {
            return $this->render(
                'kycForm/form-v2.html.twig',
                ['form'=>$formBuilder->getForm()->createView()]
            );
        }
        return $this->render(
            'kycForm/form.html.twig',
            ['form'=>$formBuilder->getForm()->createView()]
        );
    }
}
