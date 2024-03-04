<?php

namespace App\Entity;

use App\Repository\DeliveryMethodRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DeliveryMethodRepository::class)]
class DeliveryMethod
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $method_name = null;

    #[ORM\OneToMany(targetEntity: Order::class, mappedBy: 'deliveryMethod')]
    private Collection $orders;

    public function __construct()
    {
        $this->orders = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMethodName(): ?string
    {
        return $this->method_name;
    }

    public function setMethodName(string $method_name): static
    {
        $this->method_name = $method_name;

        return $this;
    }

    /**
     * @return Collection<int, Order>
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function addOrder(Order $order): static
    {
        if (!$this->orders->contains($order)) {
            $this->orders->add($order);
            $order->setDeliveryMethod($this);
        }

        return $this;
    }

    public function removeOrder(Order $order): static
    {
        if ($this->orders->removeElement($order)) {
            // set the owning side to null (unless already changed)
            if ($order->getDeliveryMethod() === $this) {
                $order->setDeliveryMethod(null);
            }
        }

        return $this;
    }
}
