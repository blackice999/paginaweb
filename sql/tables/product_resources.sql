CREATE TABLE `product_resources` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `location` varchar(255) NOT NULL,
  `mime_type` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


ALTER TABLE `product_resources`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `product_resources`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `product_resources`
  ADD CONSTRAINT `fk_product_resources_products` FOREIGN KEY (`id`) REFERENCES `products` (`id`);
