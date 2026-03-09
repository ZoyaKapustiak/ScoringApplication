<?php

namespace App\Command;

use App\Action\ScoringCalculateAction;
use App\Dto\Internal\ScoringDto;
use App\Repository\ClientRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(name: 'scoring:calculate', description: 'Update scoring calculation')]
class ScoringCalculateCommand extends Command
{
    public function __construct(
        private readonly ClientRepository $clientRepository,
        private readonly ScoringCalculateAction $scoringCalculateAction,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addArgument(name: 'id', mode: InputArgument::OPTIONAL, description: 'ID of Client');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $id = $input->getArgument('id');

        if ($id) {
            $client = $this->clientRepository->find($id);
            if (!$client) {
                $io->error("Client with ID: {$id} not found");

                return Command::FAILURE;
            }
            $clientsIds = [$id];
        } else {
            $clientsIds = $this->clientRepository->findAllIds();
        }
        $clientsChunk = array_chunk($clientsIds, 5);

        $io->section('ДЕТАЛИЗАЦИЯ');

        foreach ($clientsChunk as $chunkIds) {
            $clients = $this->clientRepository->getByIds($chunkIds);
            $results = $this->scoringCalculateAction->updateClientsScoring($clients);

            $table = $io->createTable();
            $table
                ->setHeaders(['ClientID', 'Total', 'Details'])
                ->setRows($this->getRowData($results))
                ->setStyle('default');

            $table->render();
        }
        $io->success('Updated successfully!');

        return Command::SUCCESS;
    }

    /**
     * @param ScoringDto[] $clientsScoring
     */
    private function getRowData(array $clientsScoring): array
    {
        $results = [];
        foreach ($clientsScoring as $idClient => $scoringDto) {
            $result['Client'] = $idClient;
            $result['Total'] = $scoringDto->totalScore;
            $detail = '';
            foreach ($scoringDto->scores as $key => $score) {
                $detail .= "$key-$score, ";
            }
            $result['Details'] = $detail;
            $results[] = $result;
        }

        return $results;
    }
}
