<?php
interface Mediator
{
    public function notify(object $sender, string $event): void;
}

class Server implements Mediator
{
    private $admin;
    private $user;

    public function __construct(Admin $admin, User $user)
    {
        $this->admin = $admin;
        $this->component1->setMediator($this);
        $this->user = $user;
        $this->component2->setMediator($this);
    }

    public function notify(object $sender, string $event): void
    {
        if ($event == "Server is down") {
            echo "Server is down! Notify admin:\n";
            $this->admin->notify();
        }

        if ($event == "Server fixed") {
            echo "Server is up! Notify all users:\n";
            $this->admin->notify();
            $this->user->notify();
        }
    }
}

interface Notification
{
    public function send(string $title, string $message);
}

class BaseComponent
{
    protected $mediator;

    public function __construct(Mediator $mediator = null)
    {
        $this->mediator = $mediator;
    }

    public function setMediator(Mediator $mediator): void
    {
        $this->mediator = $mediator;
    }
}

class Admin extends BaseComponent implements Notification
{
    private $email;

    public function __construct(string $email)
    {
        $this->email = $email;
    }

    public function notify(string $title, string $message): string
    {
        return "Sent email with title '$title' to '{$this->email}' that says '$message'.";
    }

    public function fixServer(): string
    {
        $this->mediator->notify($this, "Server fixed");
        return "Sent email with title '$title' to '{$this->email}' that says '$message'.";
    }
}

class GoogleApi
{
    private $login;
    private $apiKey;

    public function __construct(string $login, string $apiKey)
    {
        $this->login = $login;
        $this->apiKey = $apiKey;
    }

    public function logIn(): void
    {
        echo "Logged in to a google account '{$this->login}'.\n";
    }

    public function sendMessage(string $message): void
    {
        echo "Posted following message : '$message'. to the user with email '$this->login'";
    }
}

class GoogleNotification implements Notification
{
    private $google;
    private $userId;

    public function __construct(GoogleApi $google)
    {
        $this->google = $google;
    }

    public function send(string $title, string $message): void
    {
        $googleMessage = "#" . $title . "# " . strip_tags($message);
        $this->google->logIn();
        $this->google->sendMessage($googleMessage);
    }
}

function clientCode(Notification $notification)
{
    echo $notification->send("Website is down!",
        "<p>Our website is not responding!</p>");
}

$notification = new EmailNotification("email@example.com");
clientCode($notification);
echo "\n\n";

$googleApi = new GoogleApi("example@google.com", "apikey");
$notification = new GoogleNotification($googleApi);
clientCode($notification);
