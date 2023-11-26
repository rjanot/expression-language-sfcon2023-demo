<?php

namespace App\DataFixtures;

use App\Domain\FeatureFlag\Entity\FeatureFlag;
use App\Domain\Kyc\Entity\Question;
use App\Domain\User\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        /**
         * USERS
         */
        $user1 = new User();
        $user1
            ->setEmail('user1@example.com')
            ->setPassword('$2y$13$S88eMZ.tUMhfxcSRq1TCjeD5FW3wy28woVpfo8gg9ZZx4kpRgBUpq') // pass
            ->setCountry('FR')
            ->setIban('NL46INGB4987790602')
            ->setGender('male')
            ->setType('individual')
        ;
        $manager->persist($user1);

        $user2 = new User();
        $user2
            ->setEmail('user2@example.com')
            ->setPassword('$2y$13$S88eMZ.tUMhfxcSRq1TCjeD5FW3wy28woVpfo8gg9ZZx4kpRgBUpq') // pass
            ->setCountry('FR')
            ->setIban('FR3630003000702424758163S52')
            ->setGender('male')
            ->setType('company')
        ;
        $manager->persist($user2);

        $user3 = new User();
        $user3
            ->setEmail('user3@example.com')
            ->setPassword('$2y$13$S88eMZ.tUMhfxcSRq1TCjeD5FW3wy28woVpfo8gg9ZZx4kpRgBUpq') // pass
            ->setCountry('BE')
            ->setIban('BE3630003000702424758163S52')
            ->setGender('female')
            ->setType('company')
        ;
        $manager->persist($user3);

        /**
         * QUESTIONS
         */
        $questionName = new Question();
        $questionName
            ->setQuestion('Your name')
            ->setConditionAlgorithm('true')
        ;
        $manager->persist($questionName);

        $questionMaidenName = new Question();
        $questionMaidenName
            ->setQuestion('Your maiden name')
            ->setConditionAlgorithm('user["gender"] == "female"')
        ;
        $manager->persist($questionMaidenName);

        $questionCorporateName = new Question();
        $questionCorporateName
            ->setQuestion('Your corporate name')
            ->setConditionAlgorithm('user["type"] == "company"')
        ;
        $manager->persist($questionCorporateName);

        $questionSiren = new Question();
        $questionSiren
            ->setQuestion('Your SIREN')
            ->setConditionAlgorithm('user["type"] == "company" and user["country"] == "FR"')
        ;
        $manager->persist($questionSiren);

        $questionSiren = new Question();
        $questionSiren
            ->setQuestion('Why are you using an IBAN from another country ?')
            ->setConditionAlgorithm('user["country"] !== substr(user["iban"], 0, 2)')
        ;
        $manager->persist($questionSiren);

        /**
         * FEATURE FLAGS
         */
        $featureFlag = new FeatureFlag();
        $featureFlag
            ->setCode('FORM_V2')
            ->setConditionAlgorithm('user["id"] % 2 == 0')
        ;
        $manager->persist($featureFlag);


        $manager->flush();
    }
}
