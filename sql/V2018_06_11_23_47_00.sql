CREATE TABLE `user` (
  `id`        INT(11)      NOT NULL AUTO_INCREMENT,
  `email`     VARCHAR(64)  NOT NULL,
  `nickname`  VARCHAR(64)  NOT NULL,
  `password`  VARCHAR(255) NOT NULL,
  `find_code` VARCHAR(32)  NULL     DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `email` (`email`)
)
  COLLATE = 'utf8mb4_unicode_ci'
  ENGINE = InnoDB;


CREATE TABLE `category` (
  `id`   INT(11)     NOT NULL AUTO_INCREMENT,
  `code` VARCHAR(16) NOT NULL,
  `name` VARCHAR(32) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `code` (`code`)
)
  COLLATE = 'utf8mb4_unicode_ci'
  ENGINE = InnoDB;

INSERT INTO category (`code`, `name`)
VALUES ('10', '家用电器');
INSERT INTO category (`code`, `name`)
VALUES ('1001', '电视');
INSERT INTO category (`code`, `name`)
VALUES ('1002', '空调');
INSERT INTO category (`code`, `name`)
VALUES ('100101', '曲面电视');
INSERT INTO category (`code`, `name`)
VALUES ('100102', '超薄电视');
INSERT INTO category (`code`, `name`)
VALUES ('100201', '壁挂式');
INSERT INTO category (`code`, `name`)
VALUES ('100202', '柜式');

INSERT INTO category (`code`, `name`)
VALUES ('11', '电脑/办公');
INSERT INTO category (`code`, `name`)
VALUES ('1101', '电脑整机');
INSERT INTO category (`code`, `name`)
VALUES ('1102', '电脑配件');
INSERT INTO category (`code`, `name`)
VALUES ('110101', '笔记本');
INSERT INTO category (`code`, `name`)
VALUES ('110102', '游戏本');
INSERT INTO category (`code`, `name`)
VALUES ('110201', '显示器');
INSERT INTO category (`code`, `name`)
VALUES ('110202', 'CPU');


CREATE TABLE `product` (
  `id`             INT(11)        NOT NULL AUTO_INCREMENT,
  `name`           VARCHAR(64)    NOT NULL,
  `price`          DECIMAL(10, 2) NOT NULL,
  `description`    TEXT           NULL,
  `pic_path`       VARCHAR(255)   NULL,
  `create_time`    DATETIME       NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `publish_status` TINYINT        NOT NULL DEFAULT '0',
  `publish_time`   DATETIME       NULL     DEFAULT NULL,
  `cat`            VARCHAR(16)    NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
)
  COLLATE = 'utf8mb4_unicode_ci'
  ENGINE = InnoDB;


CREATE TABLE `order` (
  `id`          INT(11)        NOT NULL AUTO_INCREMENT,
  `user_id`     INT(11)        NOT NULL,
  `price`       DECIMAL(10, 2) NOT NULL,
  `create_time` DATETIME       NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status`      TINYINT        NOT NULL DEFAULT '0',
  `address`     VARCHAR(255)   NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  INDEX `user_id` (`user_id`)
)
  COLLATE = 'utf8mb4_unicode_ci'
  ENGINE = InnoDB;


CREATE TABLE `order_item` (
  `id`         INT(11) NOT NULL AUTO_INCREMENT,
  `order_id`   INT(11) NOT NULL,
  `product_id` INT(11) NOT NULL,
  `quantity`   TINYINT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `order_id` (`order_id`),
  INDEX `product_id` (`product_id`)
)
  COLLATE = 'utf8mb4_unicode_ci'
  ENGINE = InnoDB;
