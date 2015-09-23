<?php

namespace WilliamEspindola\Field\Console\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;
use WilliamEspindola\Field\Repository\CollectionRepository;
use WilliamEspindola\Field\Repository\FieldRepository;
use WilliamEspindola\Field\Repository\LanguageRepository;
use WilliamEspindola\Field\Repository\OptionRepository;

class Create extends AbstractCommand
{
    protected function configure()
    {
        parent::configure();

        $this->setName('create')
            ->setDescription('Create a Field, a Collection or a Language. ')
            ->addArgument('Field|Collection|Language', InputArgument::REQUIRED, 'Field, Collection or Language')
            ->addArgument('name', InputArgument::REQUIRED, 'The name is the identify of our registry')
            ->addArgument('label', InputArgument::REQUIRED, 'The Label for the presentation of your registry')
            ->addArgument('language', InputArgument::OPTIONAL, 'The Language of registry. Required when create Field and Collections')
            ->addArgument('type', InputArgument::OPTIONAL, 'The type of field (only field has types)')
            ->addArgument('collection', InputArgument::OPTIONAL, 'The collection name of field new field')
            ->setHelp(sprintf(
                "%sCreates examples:
                create Language en_EN English
                create Collection header Header en_EN
                create Field about \"About text\" en_EN html
                create Field meta-keys Metakeys en_EN text header
                create Field contact Contact en_EN text
                create Option Girl contact en_EN
                create Option Boy contact en_EN %s",
                PHP_EOL,
                PHP_EOL
            ));
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->bootstrap($input, $output);

        $storage = $this->getStorage()->getMapperInstance();

        if ($input->getArgument('Field|Collection|Language') != 'Language'
            AND $input->getArgument('language') == null
        ) {
            $output->writeln('<error>The Language param is required to create a Field, Collection or Option.</error>');
        }

        if ($input->getArgument('Field|Collection|Language') != 'Language'
            AND !$this->findALanguage($input, $storage)
        ) {
            $output->writeln('<error>The Language ' . $input->getArgument('language') . ' not found.</error>');
            return;
        }

        if ($input->getArgument('Field|Collection|Language') == 'Language'
            AND $this->findALanguage($input, $storage)
        ) {
            $output->writeln('<error>The Language ' . $input->getArgument('language') . ' exist.</error>');
            return;
        }

        switch ($input->getArgument('Field|Collection|Language')) {
            case 'Collection':
                    $language = $this->findALanguage($input, $storage);
                    $this->createCollection($input, $storage, $language);
                    $output->writeln('<info>Collection ' . $input->getArgument('name') . ' was been created.</info>');
                    return;
                break;
            case 'Language';
                    $this->createLanguage($input, $storage);
                    $output->writeln('<info>Language ' . $input->getArgument('name') . ' was been created.</info>');
                    return;
                break;
            case 'Field';
                    if ($input->getArgument('collection') != null) {
                        $collection = $this->findACollection($input, $storage);
                        if (!$collection) {
                            $output->writeln('<error>The Collection ' . $input->getArgument('collection') . ' not found.</error>');
                            return;
                        }

                        $language = $this->findALanguage($input, $storage);
                        $this->createTheFieldOnCollection($input, $collection[0], $storage, $language);
                        $output->writeln(
                            '<info>Field '
                            . $input->getArgument('name')
                            . ' was been created with to collection '
                            . $input->getArgument('collection')
                            . '</info>');
                        return;
                    }

                    $language = $this->findALanguage($input, $storage);
                    $this->createField($input, $storage, $language);
                    $output->writeln('<info>Field ' . $input->getArgument('name') . ' was been created.</info>');
                    return;
                break;
            case 'Option';
                    $language = $this->findALanguage($input, $storage);
                    $field = $this->findField($input->getArgument('label'), $storage);
                    if (!$field) {
                        $output->writeln('<error>The Field ' . $input->getArgument('label') . ' not found.</error>');
                        return;
                    }
                    $this->createOption($input, $storage, $language, $field);
                    $output->writeln('<info>Option ' . $input->getArgument('name') . ' was been created.</info>');
                    return;
                break;
        }
    }

    private function createCollection(InputInterface $input, $storage, $language)
    {
        $collectionRepository   = new CollectionRepository($storage);

        $collection = (object)([
            'name' => $input->getArgument('name'),
            'label' => $input->getArgument('label'),
            'language_id' => $language[0]->id,
        ]);

        $collectionRepository->save($collection);

        return $collection;
    }

    private function createOption(InputInterface $input, $storage, $language, $field)
    {
        $optionRepository   = new OptionRepository($storage);

        $option = (object)([
            'text' => $input->getArgument('name'),
            'language_id' => $language[0]->id,
            'field_id' => $field->id
        ]);

        $optionRepository->save($option);

        return $option;
    }

    private function createField(InputInterface $input, $storage, $language)
    {
        $fieldRepository    = new FieldRepository($storage);

        $field = (object)([
            'type' => $input->getArgument('type'),
            'name' => $input->getArgument('name'),
            'label' => $input->getArgument('label'),
            'language_id' => $language[0]->id,
        ]);

        $fieldRepository->save($field);

        return $field;
    }

    private function createTheFieldOnCollection(
        InputInterface $input,
        $collection,
        $storage,
        $language
    ) {
        $fieldRepository    = new FieldRepository($storage);

        $field = (object)([
            'type' => $input->getArgument('type'),
            'name' => $input->getArgument('name'),
            'label' => $input->getArgument('label'),
            'language_id' => $language[0]->id,
            'collection_id' => $collection->id
        ]);

        $fieldRepository->save($field);

        return $field;
    }

    private function findACollection(InputInterface $input, $storage)
    {
        $collectionRepository = new CollectionRepository($storage);

        return $collectionRepository->findBy(
            ['name' => $input->getArgument('collection')],
            ['order by name']
        );
    }

    private function findALanguage(InputInterface $input, $storage)
    {
        $languageRepository = new LanguageRepository($storage);

        return $languageRepository->findBy(
            ['name' => $input->getArgument('language')],
            ['order by name']
        );
    }

    private function createLanguage(InputInterface $input, $storage)
    {
        $languageRepository   = new LanguageRepository($storage);

        $language = (object)([
            'name' => $input->getArgument('name'),
            'label' => $input->getArgument('label')
        ]);

        $languageRepository->save($language);

        return $language;
    }

    private function findField($name, $storage)
    {
        $fieldRepository    = new FieldRepository($storage);

        $field = $fieldRepository->findBy(
            ['name' => $name],
            ['order by name']
        );

        return $field;
    }
}
