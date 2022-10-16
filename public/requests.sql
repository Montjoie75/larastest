select c.first_name as name, s.name as store, count(v.created_at) as visits, min(v.created_at) as first_visit, max(v.created_at) as last_visit from visits as v inner join customers as c on c.id=v.customer_id inner join stores as s on s.id=v.store_id group by c.id