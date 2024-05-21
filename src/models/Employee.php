<?php

class Employee implements JsonSerializable
{
    private $id;
    private string $name;
    private string $email;
    private string $department;
    private string $image;
    private string|null $about;

    public function getAbout(): string
    {
        return $this->about;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getDepartment(): string
    {
        return $this->department;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getImage(): string
    {
        return $this->image;
    }

    /**
     * @param string $image
     */
    public function setImage(string $image): void
    {
        $this->image = $image;
    }

    /**
     * @param string|null $about
     */
    public function setAbout(string|null $about): void
    {
        $this->about = $about;
    }

    /**
     * @param string $department
     */
    public function setDepartment(string $department): void
    {
        $this->department = $department;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @param string $id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function __toString(): string
    {
        return "{'name':$this->name, 'email':$this->email, 'department':$this->department, 'image':$this->image}";
    }

    public static function toObject($input): Employee
    {
        $emp = new Employee();
        $decoded = json_decode($input, true);
        $emp->setId($decoded["id"]);
        $emp->setName($decoded["name"]);
        $emp->setAbout($decoded["about"]);
        $emp->setImage($decoded["image"]);
        $emp->setEmail($decoded["email"]);
        $emp->setDepartment($decoded["department"]);
        return $emp;
    }
    public function jsonSerialize(): array
    {
        return get_object_vars($this);
    }

}
