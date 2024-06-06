-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `mydb` DEFAULT CHARACTER SET utf8 ;
USE `mydb` ;

-- -----------------------------------------------------
-- Table `mydb`.`User`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`User` (
  `id` INT NOT NULL,
  `name` VARCHAR(45) NOT NULL,
  `password` VARCHAR(45) NOT NULL,
  `email` VARCHAR(45) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Group`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`Group` (
  `id` INT NOT NULL,
  `name` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Action`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`Action` (
  `id` INT NOT NULL,
  `name` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`User_Group`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`User_Group` (
  `id` INT NOT NULL,
  `User_id` INT NOT NULL,
  `Group_id` INT NOT NULL,
  PRIMARY KEY (`id`, `User_id`, `Group_id`),
  INDEX `fk_User_Group_User_idx` (`User_id` ASC),
  INDEX `fk_User_Group_Group1_idx` (`Group_id` ASC),
  CONSTRAINT `fk_User_Group_User`
    FOREIGN KEY (`User_id`)
    REFERENCES `mydb`.`User` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_User_Group_Group1`
    FOREIGN KEY (`Group_id`)
    REFERENCES `mydb`.`Group` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Group_Action`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`Group_Action` (
  `id` INT NOT NULL,
  `Group_id` INT NOT NULL,
  `Action_id` INT NOT NULL,
  PRIMARY KEY (`id`, `Group_id`, `Action_id`),
  INDEX `fk_Group_Action_Group1_idx` (`Group_id` ASC),
  INDEX `fk_Group_Action_Action1_idx` (`Action_id` ASC),
  CONSTRAINT `fk_Group_Action_Group1`
    FOREIGN KEY (`Group_id`)
    REFERENCES `mydb`.`Group` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Group_Action_Action1`
    FOREIGN KEY (`Action_id`)
    REFERENCES `mydb`.`Action` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
