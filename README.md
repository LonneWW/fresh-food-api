# FreshFoodAPI

FreshFoodAPI is the project I made for the start2impact University's full stack course.

## Features

- **Order Management**

  - Create new orders
  - Retrieve all orders
  - Filter orders based on CO2 emissions
  - Update and delete orders

- **Product Management**
  - Add new products
  - Retrieve all available products
  - Modify and delete products

## Installation and configurations

1. **Clone the repository**
   ```
   git clone https://github.com/your-username/FreshFoodAPI.git
   ```
2. **Navigate to the project directory**
   ```
   cd FreshFoodAPI
   ```
3. **Install dependencies with composer (install it first if needed)**
   ```
   composer install
   ```
4. **Configure the database**
   - Create an `.env` file based on the `.env.example one`.
   - Use the code inside `migrations.sql` to re-create the database inside your SQL.

To test the API you can use tools like Postman.

## REST API

**Data**
`order-type`:

```
{
  "id": 1,
  "order_date": "2025-08-22 20:15:18",
  "destination_country": "Country",
  "product_name": "Product",
  "product_quantity": 11
}
```

`product-type`:

```
{
  "name": "Product Name",
  "co2_spared": 8
}
```

**Endpoints and Methods**

- **Orders**

  - **GET**

    `.../FreshFoodAPI/orders`

  - **GET (Co2 Spared, with filters)**

    `.../FreshFoodAPI/orders/Co2`

  Example with filters:

  `.../FreshFoodAPI/orders/Co2?order_date=from2024-01-01T00:00:00to2025-00-00T00:00:00`

  `.../FreshFoodAPI/orders/Co2?product_name=Canned_Spaghetti`

  `.../FreshFoodAPI/orders/Co2?destination_country=Italy`

  - **POST**

    `.../FreshFoodAPI/orders`

    Body:

    ```
    {
      "order_date" : "2025-00-00 00:00:00",
      "destination_country" : "Country",
      "product_name" : "Product_Name",
      "product_quantity": 10
    }
    ```

  - **PATCH**

    `.../FreshFoodAPI/orders/{id}`

    Body:

    ```
    {
      "order_date" : "2025-00-00 00:00:00",
      "destination_country" : "Country",
      "product_name" : "Product_Name",
      "product_quantity": 10
    }
    ```

  - **DELETE**

    `.../FreshFoodAPI/orders/{id}`

- **Products**

  - **GET**

    `.../FreshFoodAPI/products`

  - **POST**

    `.../FreshFoodAPI/products`

    Body:

    ```
    {
      "name" : "Product_Name",
      "co2_spared": 10
    }
    ```

  - **PATCH**

    `.../FreshFoodAPI/products/{name}`

    Body:

    ```
    {
      "co2_spared": 12
    }
    ```

  - **DELETE**

    `.../FreshFoodAPI/products/{name}`

  ** The request will contain either the complete list of all orders/products or only the portion filtered according to the type of response. **

## Dependencies

- PHP >= 8.0
- MySQL
- Composer
