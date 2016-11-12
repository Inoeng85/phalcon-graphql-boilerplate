<?php

namespace App\Bootstrap;

use App\BootstrapInterface;
use App\Handlers\ProjectHandler;
use Phalcon\Config;
use Phalcon\DiInterface;
use PhalconRest\Api;
use Schema\Definition\EnumType;
use Schema\Definition\EnumTypeValue;
use Schema\Definition\Field;
use Schema\Definition\InputField;
use Schema\Definition\ObjectType;
use Schema\Definition\Schema;

class SchemaBootstrap implements BootstrapInterface
{
    public function run(Api $api, DiInterface $di, Config $config)
    {

        /**
         * Define Schema
         */
        $schema = Schema::factory()
            /**
             * Define Enum Types
             */
            ->enumType(EnumType::factory()
                ->name('ProjectStateEnum')
                ->description('Represents the state of the project')
                ->value(EnumTypeValue::factory()
                    ->name('OPEN')
                    ->description('Open')
                    ->value(0)
                )
                ->value(EnumTypeValue::factory()
                    ->name('CLOSED')
                    ->description('Closed')
                    ->value(1)
                )
            )
            ->enumType(EnumType::factory()
                ->name('TicketStateEnum')
                ->description('Represents the state of the ticket')
                ->value(EnumTypeValue::factory()
                    ->name('NEW')
                    ->description('New')
                    ->value(0)
                )
                ->value(EnumTypeValue::factory()
                    ->name('IN_PROGRESS')
                    ->description('In Progress')
                    ->value(1)
                )
                ->value(EnumTypeValue::factory()
                    ->name('COMPLETED')
                    ->description('Completed')
                    ->value(2)
                )
            )
            /**
             * Define Object Types
             */
            ->objectType(ObjectType::factory()
                ->name('Query')
                ->field(Field::factory()
                    ->name('viewer')
                    ->type('Viewer')
                    ->nonNull()
                    ->resolver(function () {
                        return [];
                    })
                )
            )
            ->objectType(ObjectType::factory()
                ->name('Viewer')
                ->field(Field::factory()
                    ->name('allProjects')
                    ->type('ProjectConnection')
                    ->nonNull()
                    ->resolver('App\Handlers\ViewerHandler::allProjects')
                )
                ->field(Field::factory()
                    ->name('findProject')
                    ->arg(InputField::factory()
                        ->name('id')
                        ->type('ID')
                    )
                    ->type('Project')
                    ->nonNull()
                    ->resolver('App\Handlers\ViewerHandler::findProject')
                )
                ->field(Field::factory()
                    ->name('allTickets')
                    ->type('TicketConnection')
                    ->nonNull()
                    ->resolver('App\Handlers\ViewerHandler::allTickets')
                )
                ->field(Field::factory()
                    ->name('findTicket')
                    ->arg(InputField::factory()
                        ->name('id')
                        ->type('ID')
                    )
                    ->type('Ticket')
                    ->nonNull()
                    ->resolver('App\Handlers\ViewerHandler::findTicket')
                )
            )
            ->objectType(ObjectType::factory()
                ->name('ProjectConnection')
                ->field(Field::factory()
                    ->name('edges')
                    ->type('ProjectEdge')
                    ->nonNull()
                    ->isList()
                    ->isNonNullList()
                )
            )
            ->objectType(ObjectType::factory()
                ->name('ProjectEdge')
                ->field(Field::factory()
                    ->name('node')
                    ->type('Project')
                    ->nonNull()
                )
            )
            ->objectType(ObjectType::factory()
                ->name('Project')
                ->description('Represents a Project')
                ->handler(ProjectHandler::class)
                ->field(Field::factory()
                    ->name('id')
                    ->type('ID')
                    ->nonNull()
                )
                ->field(Field::factory()
                    ->name('title')
                    ->description('Title of the Project')
                    ->type('String')
                    ->nonNull()
                )
                ->field(Field::factory()
                    ->name('state')
                    ->description('State of the Project')
                    ->type('ProjectStateEnum')
                    ->nonNull()
                )
                ->field(Field::factory()
                    ->name('tickets')
                    ->description('Tickets of the Project')
                    ->type('TicketConnection')
                    ->nonNull()
                )
            )
            ->objectType(ObjectType::factory()
                ->name('TicketConnection')
                ->field(Field::factory()
                    ->name('edges')
                    ->type('TicketEdge')
                    ->isList()
                    ->isNonNullList()
                    ->nonNull()
                )
            )
            ->objectType(ObjectType::factory()
                ->name('TicketEdge')
                ->field(Field::factory()
                    ->name('node')
                    ->type('Ticket')
                    ->nonNull()
                )
            )
            ->objectType(ObjectType::factory()
                ->name('Ticket')
                ->description('Represents a Ticket')
                ->field(Field::factory()
                    ->name('id')
                    ->type('ID')
                    ->nonNull()
                )
                ->field(Field::factory()
                    ->name('title')
                    ->description('Title of the Ticket')
                    ->type('String')
                    ->nonNull()
                )
                ->field(Field::factory()
                    ->name('state')
                    ->description('State of the Ticket')
                    ->type('TicketStateEnum')
                    ->nonNull()
                )
                ->field(Field::factory()
                    ->name('private')
                    ->description('Whether the Ticket is private or not')
                    ->type('Boolean')
                    ->nonNull()
                )
                ->field(Field::factory()
                    ->name('amountHours')
                    ->description('How many hours the Ticket will cost to resolve')
                    ->type('Int')
                    ->nonNull()
                )
                ->field(Field::factory()
                    ->name('project')
                    ->description('Project of the Ticket')
                    ->type('Project')
                    ->resolver('App\Handlers\TicketHandler::project')
                )
            );

        $di->setShared('schema', $schema);
    }
}
