<?php declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Metadata\ApiFilter;
use App\Doctrine\Trait\TimestampableTrait;
use App\Doctrine\Trait\UuidTrait;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Metadata\Patch;
use App\Api\Processor\CreateScoreProcessor;
use App\Api\Processor\UpdateScoreProcessor;

#[ORM\Entity]
#[GetCollection]
#[Post(processor: CreateScoreProcessor::class)]
#[Patch(
    processor: UpdateScoreProcessor::class,
)]
#[ORM\Table(name: 'score')]
#[ApiFilter(OrderFilter::class, properties: ['score' => 'desc'])]
class Score
{
    use UuidTrait;
    use TimestampableTrait;

    #[ORM\Column]
    #[Assert\NotBlank]
    public ?int $score = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: 'user_uuid', referencedColumnName: 'uuid', nullable: false, onDelete: 'CASCADE')]
    public ?User $user = null;

    public function __construct()
    {
        $this->defineUuid();
    }
}