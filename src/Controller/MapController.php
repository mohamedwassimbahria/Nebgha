<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class MapController extends AbstractController implements MessageComponentInterface
{
    private $connections = [];
    private $mapData = []; // Contient les informations des points sur la carte

    #[Route('/map', name: 'map_view', methods: ['GET'])]
    public function view(): Response
    {
        return $this->render('evenement/meet.html.twig');
    }

    public function onOpen(ConnectionInterface $conn)
    {
        $this->connections[$conn->resourceId] = $conn;
    }

    public function onMessage(ConnectionInterface $from, $msg)
    {
        $data = json_decode($msg, true);

        if ($data['type'] === 'addMarker') {
            $this->mapData[] = [
                'id' => uniqid(),
                'lat' => $data['lat'],
                'lng' => $data['lng'],
                'description' => $data['description'] ?? 'No description',
            ];

            foreach ($this->connections as $connection) {
                $connection->send(json_encode([
                    'type' => 'updateMap',
                    'mapData' => $this->mapData,
                ]));
            }
        }
    }

    public function onClose(ConnectionInterface $conn)
    {
        unset($this->connections[$conn->resourceId]);
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        $conn->close();
    }
}

