<?php

namespace App\Twig;

use App\Entity\Forum;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class ForumExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            // If your filter generates SAFE HTML, you should add a third
            // parameter: ['is_safe' => ['html']]
            // Reference: https://twig.symfony.com/doc/3.x/advanced.html#automatic-escaping
            new TwigFilter('count_message_by_forum', [$this, 'countMessageByForum']),
            // 1er paramètre -> nom du filter : count_message_by_forum
            // 2eme paramètre tableau avec -> $this : là ou on applique notre filtre et 
            // countMessageByForum : méthode à créer dans notre fichier
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('function_name', [$this, 'doSomething']),
        ];
    }

    public function countMessageByForum(Forum $forum)
    {
        $numMessage= 0;
        foreach ($forum->getTopics() as $topic){
            /**@var Topic $topic */

            foreach ($topic->getMessages() as $message){
                $numMessage++;
            }
        }
        return $numMessage;
    }
}
