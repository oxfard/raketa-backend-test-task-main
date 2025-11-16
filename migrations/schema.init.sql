create table if not exists categories
(
    id bigint unsigned auto_increment primary key,
    name varchar(255) not null comment 'Наименование категории товара',
    description text null comment 'Описание категории товара'
)
    comment 'Категории товаров';

create table if not exists products
(
    id bigint unsigned auto_increment primary key,
    uuid char(36) not null unique comment 'UUID товара',
    category_id bigint unsigned not null comment 'ID категории товара',
    is_active tinyint default 1  not null comment 'Флаг активности',
    name varchar(255) not null comment 'Имя товара',
    description text null comment 'Описание товара',
    thumbnail varchar(255) null comment 'Ссылка на картинку',
    price decimal(10, 2) not null comment 'Цена',
    foreign key (category_id) references categories(id) on delete restrict
)
    comment 'Товары';

create index is_active_idx on products (is_active);