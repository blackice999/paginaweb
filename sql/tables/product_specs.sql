CREATE TABLE `product_specs` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


ALTER TABLE `product_specs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_product_specs_products` (`product_id`);


ALTER TABLE `product_specs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `product_specs`
  ADD CONSTRAINT `fk_product_specs_products` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);