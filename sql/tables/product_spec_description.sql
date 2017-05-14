CREATE TABLE `product_spec_description` (
  `id` int(11) NOT NULL,
  `product_spec_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


ALTER TABLE `product_spec_description`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_product_spec_description_product_specs` (`product_spec_id`);


ALTER TABLE `product_spec_description`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `product_spec_description`
  ADD CONSTRAINT `fk_product_spec_description_product_specs` FOREIGN KEY (`product_spec_id`) REFERENCES `product_specs` (`id`);