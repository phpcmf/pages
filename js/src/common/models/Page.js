import app from 'cmf/app';
import Model from 'cmf/common/Model';
import computed from 'cmf/common/utils/computed';
import { getPlainContent } from 'cmf/common/utils/string';
import ItemList from 'cmf/common/utils/ItemList';
import Badge from 'cmf/common/components/Badge';

export default class Page extends Model {
  title = Model.attribute('title');
  time = Model.attribute('time', Model.transformDate);
  editTime = Model.attribute('editTime', Model.transformDate);
  content = Model.attribute('content');
  contentHtml = Model.attribute('contentHtml');
  contentPlain = computed('contentHtml', getPlainContent);
  slug = Model.attribute('slug');
  isHidden = Model.attribute('isHidden');
  isRestricted = Model.attribute('isRestricted');
  isHtml = Model.attribute('isHtml');

  badges() {
    const items = new ItemList();

    if (this.isHidden()) {
      items.add(
        'hidden',
        Badge.component({
          type: 'hidden',
          icon: 'fas fa-trash',
          label: app.translator.trans('cmf-pages.admin.badges.hidden'),
        })
      );
    }

    if (this.isRestricted()) {
      items.add(
        'restricted',
        Badge.component({
          type: 'restricted',
          icon: 'fas fa-user-shield',
          label: app.translator.trans('cmf-pages.admin.badges.restricted'),
        })
      );
    }

    return items;
  }
}
