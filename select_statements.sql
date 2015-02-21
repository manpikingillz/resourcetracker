SELECT distinct r.organisation_id, r.organisation_name, ot.organisation_type_name, r.fiscal_year_start, r.provided_pools_fund_for_health, r.signed_mou_with_moh, r.date_started_working_in_districts, a.authority_name, r.contact_name, r.mobile_phone, r.office_phone, r.email FROM organisation r inner join organisation_type ot on r.organisation_type_id = ot.organisation_type_id inner join authority a on r.authority_consulted_Id = a.authority_id where r.organisation_id=2;

SELECT b.budget_id, fc.currency_name as financing_currency, sc.currency_name as spending_currency, f.financial_year_name, b.total_budget, p.project_name, concat(p.project_name, ' ( ', b.total_budget, ' )') as project_and_total_amount FROM budget b inner join currency fc on b.financing_currency_id = fc.currency_id inner join currency sc on b.spending_currency_id = sc.currency_id inner join financial_year f on b.financial_year_id = f.financial_year_id inner join project p on b.project_id = p.project_id;


SELECT distinct o.sub_category_of_support_id, o.sub_category_of_support_name, t.type_of_support_name as type_of_support_name FROM sub_category_of_support o inner join type_of_support t on o.type_of_support_id = t.type_of_support_id order by o.sub_category_of_support_name desc;


SELECT tsb.type_of_support_budget_id, ts.type_of_support_name, b.total_budget, tsb.budget_amount, b.project_and_total_amount FROM type_of_support_budget tsb inner join type_of_support ts on tsb.type_of_support_id = ts.type_of_support_id inner join (SELECT b.budget_id, fc.currency_name as financing_currency, sc.currency_name as spending_currency, f.financial_year_name, b.total_budget, p.project_name, concat(p.project_name, ' ( ', b.total_budget, ' )') as project_and_total_amount FROM budget b inner join currency fc on b.financing_currency_id = fc.currency_id inner join currency sc on b.spending_currency_id = sc.currency_id inner join financial_year f on b.financial_year_id = f.financial_year_id inner join project p on b.project_id = p.project_id) b on tsb.budget_id = b.budget_id;


SELECT distinct p.partner_id, pt.partner_type_name, p.partner_name, p.partner_contact_name, p.partner_contact_phone, p.partner_contact_email from partner p inner join partner_type pt on p.partner_type_id = pt.partner_type_id;


SELECT distinct r.project_id, r.project_name, r.project_description, fo.organisation_name as financing_agent, impo.organisation_name as implementer from project r inner join organisation fo on r.organisation_financing_agent_id = fo.organisation_id inner join organisation impo on r.organisation_implementer_id = impo.organisation_id where r.project_id=2;


SELECT distinct r.project_id, r.project_name, r.project_description, fo.organisation_name as financing_agent, impo.organisation_name as implementer from project r inner join organisation fo on r.organisation_financing_agent_id = fo.organisation_id inner join organisation impo on r.organisation_implementer_id = impo.organisation_id;


SELECT p.project_sub_category_of_support_budget_id, tsb.budget_amount as type_of_support_budget_amount, sof.sub_category_of_support_name, p.budget_amount as sub_category_of_support_budget_amount FROM project_sub_category_of_support_budget p inner join type_of_support_budget tsb on p.type_of_support_budget_id = tsb.type_of_support_budget_id inner join sub_category_of_support sof on p.sub_category_of_support_id = sof.sub_category_of_support_id;

SELECT nb.national_budget_id, b.total_budget, nb.budget_amount as national_budget_amount, b.project_and_total_amount FROM national_budget nb inner join (SELECT b.budget_id, fc.currency_name as financing_currency, sc.currency_name as spending_currency, f.financial_year_name, b.total_budget, p.project_name, concat(p.project_name, ' ( ', b.total_budget, ' )') as project_and_total_amount FROM budget b inner join currency fc on b.financing_currency_id = fc.currency_id inner join currency sc on b.spending_currency_id = sc.currency_id inner join financial_year f on b.financial_year_id = f.financial_year_id inner join project p on b.project_id = p.project_id) b on nb.budget_id = b.budget_id;

SELECT distinct a.national_budget_cost_category_id,cc.cost_category_name, a.national_budget_amount, concat(b.project_and_total_amount,' - National ational Budget -', b.national_budget_amount)  from national_budget_cost_category a inner join cost_category cc on a.cost_category_id = cc.cost_category_id inner join (SELECT nb.national_budget_id, b.total_budget, nb.budget_amount as national_budget_amount, b.project_and_total_amount FROM national_budget nb inner join (SELECT b.budget_id, fc.currency_name as financing_currency, sc.currency_name as spending_currency, f.financial_year_name, b.total_budget, p.project_name, concat(p.project_name, ' ( ', b.total_budget, ' )') as project_and_total_amount FROM budget b inner join currency fc on b.financing_currency_id = fc.currency_id inner join currency sc on b.spending_currency_id = sc.currency_id inner join financial_year f on b.financial_year_id = f.financial_year_id inner join project p on b.project_id = p.project_id) b on nb.budget_id = b.budget_id) b on a.national_budget_id = b.national_budget_id;

