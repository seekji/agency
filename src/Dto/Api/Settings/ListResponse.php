<?php

declare(strict_types=1);

namespace App\Dto\Api\Settings;

use App\Dto\Api\Settings\Achievement\Achievement;
use App\Dto\Api\Settings\Menu\Menu;
use App\Dto\Api\Settings\SocialLink\SocialLink;
use App\Dto\Api\Settings\Translation\Translation;
use App\Dto\Api\Video\Video;
use App\Entity\Settings;
use JMS\Serializer\Annotation\Type;

class ListResponse
{
    /**
     * @Type("array")
     */
    public $translations = [];

    /**
     * @var SocialLink[]
     * @Type("array<App\Dto\Api\Settings\SocialLink\SocialLink>")
     */
    public $socialLinks;

    /**
     * @var Menu[]
     * @Type("array<App\Dto\Api\Settings\Menu\Menu>")
     */
    public $menuLinks;

    /**
     * @var Achievement[]
     * @Type("array<App\Dto\Api\Settings\Achievement\Achievement>")
     */
    public $achievements;

    /**
     * @Type("string")
     */
    public $privacy;

    /**
     * @Type("string")
     */
    public $terms;

    /**
     * @Type("string")
     */
    public $phone;

    /**
     * @Type("string")
     */
    public $address;

    /**
     * @Type("string")
     */
    public $email;

    /**
     * @Type("App\Dto\Api\Video\Video")
     */
    public $video;

    public function __construct(Settings $settings)
    {
        $this->phone = $settings->getPhone();
        $this->email = $settings->getEmail();
        $this->privacy = $settings->getPrivacy();
        $this->address = $settings->getAddress();
        $this->terms = $settings->getTerms();
        $this->video = new Video($settings->getVideo());

        if ($settings->getTranslations()) {
            foreach ($settings->getTranslations() as $translation) {
                $translationObject = new Translation($translation);
                $this->translations[$translationObject->key] = $translationObject->translation;
            }
        }

        if ($settings->getSocialLinks()) {
            foreach ($settings->getSocialLinks() as $socialLink) {
                $this->socialLinks[] = new SocialLink($socialLink);
            }
        }

        if ($settings->getAchievements()) {
            foreach ($settings->getAchievements() as $achievement) {
                $this->achievements[] = new Achievement($achievement);
            }
        }

        if ($settings->getMenuLinks()) {
            foreach ($settings->getMenuLinks() as $menuItem) {
                $this->menuLinks[] = new Menu($menuItem);
            }

            usort($this->menuLinks, function($a, $b) {
                return $a->sort <=> $b->sort;
            });
        }
    }
}