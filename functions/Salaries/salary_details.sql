-- -- Employee Table
-- CREATE TABLE employees (
--     emp_id INT PRIMARY KEY AUTO_INCREMENT,
--     designation VARCHAR(100),
--     function VARCHAR(100),
--     date_of_join DATE,
--     location VARCHAR(100),
--     created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
-- );

-- -- Combined Salary Table
-- CREATE TABLE salary_details (
--     id INT PRIMARY KEY AUTO_INCREMENT,
--     emp_id INT,
    
--     -- Monthly Components
--     basic_pay DECIMAL(10, 2),
--     hra DECIMAL(10, 2),
--     children_education_allowance DECIMAL(10, 2),
--     special_allowance DECIMAL(10, 2),
--     gross_salary DECIMAL(10, 2),
    
--     -- Deductions
--     professional_tax DECIMAL(10, 2),
--     provident_fund DECIMAL(10, 2),
--     tds DECIMAL(10, 2),
--     total_deductions DECIMAL(10, 2),
--     net_payable DECIMAL(10, 2),
    
--     -- Annual Benefits
--     lta DECIMAL(10, 2),
--     performance_pay DECIMAL(10, 2),
--     pf_employer_contribution DECIMAL(10, 2),
--     gratuity DECIMAL(10, 2),
--     medical_insurance DECIMAL(10, 2),
    
--     -- Total CTC
--     fixed_ctc DECIMAL(10, 2),
    
--     effective_from DATE,
--     effective_to DATE,
--     FOREIGN KEY (emp_id) REFERENCES employees(emp_id)
-- );