<?php

/*
 * This file is part of the broadway/broadway-demo package.
 *
 * (c) 2020 Broadway project
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace BroadwayDemo\Command;

use BroadwayDemo\ReadModel\DBALRepository;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Schema\Schema;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * drops the read model table.
 */
class DropReadModelCommand extends ContainerAwareCommand
{
    /**
     * @var Connection
     */
    private $connection;

    /**
     * @var DBALRepository
     */
    private $repository;

    /**
     * @var string
     */
    private $commandName;

    public function __construct(Connection $connection, DBALRepository $repository, string $commandName)
    {
        $this->repository = $repository;
        $this->connection = $connection;
        $this->commandName = $commandName;

        parent::__construct();
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        parent::configure();

        $this
            ->setName($this->commandName)
            ->setDescription('Drops the read model table');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $schemaManager = $this->connection->getSchemaManager();
        $table = $this->repository->configureTable(new Schema());

        if ($schemaManager->tablesExist($table->getName())) {
            $schemaManager->dropTable($table->getName());
            $output->writeln('<info>Dropped Broadway read model schema</info>');
        } else {
            $output->writeln('<info>Broadway read model schema does not exist</info>');
        }
    }
}
